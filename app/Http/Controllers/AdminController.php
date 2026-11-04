<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view('auth.admin');
    }

    public function borrowIndex(Request $request)
    {
        self::syncOverdueBorrows();

        $status = $request->input('status', 'pending');
        $keyword = trim($request->input('search', ''));
        $page = (int) $request->input('page', 1);
        $perPage = 10;

        // --- 1. TÍNH SỐ LƯỢNG CHO TỪNG TRẠNG THÁI (ĐỂ HIỂN THỊ LÊN TAB) ---
        $statuses = ['pending', 'borrowing', 'returned', 'overdue', 'rejected'];
        $statusCounts = [];

        foreach ($statuses as $st) {
            $countQuery = DB::table('borrow')
                ->join('user', 'borrow.user_id', '=', 'user.user_id')
                ->where('borrow.status', $st);

            // Nếu đang tìm kiếm, đếm theo kết quả tìm kiếm luôn cho trực quan
            if (!empty($keyword)) {
                $countQuery->where(function ($q) use ($keyword) {
                    $q->where('borrow.borrow_id', 'LIKE', "%{$keyword}%")
                        ->orWhere('user.student_name', 'LIKE', "%{$keyword}%")
                        ->orWhere('user.email', 'LIKE', "%{$keyword}%");
                });
            }

            $statusCounts[$st] = $countQuery->count();
        }
        // -------------------------------------------------------------

        // 2. Khởi tạo Query builder chính để lấy danh sách hiển thị bảng
        $query = DB::table('borrow')
            ->join('user', 'borrow.user_id', '=', 'user.user_id')
            ->select(
                'borrow.*',
                'user.student_name as user_name',
                'user.email as user_email'
            );

        if (!empty($status)) {
            $query->where('borrow.status', $status);
        }

        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('borrow.borrow_id', 'LIKE', "%{$keyword}%")
                    ->orWhere('user.student_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('user.email', 'LIKE', "%{$keyword}%");
            });
        }

        $totalItems = $query->count();
        $totalPages = (int) ceil($totalItems / $perPage);
        $page = max(1, min($page, max(1, $totalPages)));
        $offset = ($page - 1) * $perPage;

        $borrows = $query->orderBy('borrow.created_at', 'desc')
            ->skip($offset)
            ->take($perPage)
            ->get();

        $borrowIds = $borrows->pluck('borrow_id');
        $details = DB::table('borrow_details')
            ->join('book', 'borrow_details.book_id', '=', 'book.book_id')
            ->whereIn('borrow_details.borrow_id', $borrowIds)
            ->select('borrow_details.*', 'book.book_name', 'book.book_image')
            ->get()
            ->groupBy('borrow_id');

        $pagination = [
            'total'        => $totalItems,
            'per_page'     => $perPage,
            'current_page' => $page,
            'total_pages'  => $totalPages,
            'has_prev'     => $page > 1,
            'has_next'     => $page < $totalPages,
            'prev_page'    => $page - 1,
            'next_page'    => $page + 1,
        ];

        // Truyền thêm biến $statusCounts sang View
        return view('admin.borrows.index', compact('borrows', 'details', 'status', 'keyword', 'pagination', 'statusCounts'));
    }

    // Xem chi tiết phiếu mượn
    public function show($id)
    {
        $borrow = DB::table('borrow')
            ->join('user', 'borrow.user_id', '=', 'user.user_id')
            ->select('borrow.*', 'user.student_name as user_name', 'user.email as user_email')
            ->where('borrow.borrow_id', $id)
            ->first();

        if (!$borrow) {
            return redirect()->route('admin.borrows.index')->with('error', 'Không tìm thấy phiếu mượn!');
        }

        $details = DB::table('borrow_details')
            ->join('book', 'borrow_details.book_id', '=', 'book.book_id')
            ->where('borrow_details.borrow_id', $id)
            ->select('borrow_details.*', 'book.book_name', 'book.book_image', 'book.author')
            ->get();

        return view('admin.borrows.show', compact('borrow', 'details'));
    }

    // Cập nhật trạng thái phiếu mượn (Duyệt, Từ chối, Đã trả)
    public function updateStatus(Request $request, $id)
    {
        $newStatus = $request->input('status');
        $allowedStatuses = ['pending', 'borrowing', 'returned', 'overdue', 'rejected'];

        if (!in_array($newStatus, $allowedStatuses)) {
            return redirect()->back()->with('error', 'Trạng thái không hợp lệ!');
        }

        // Lấy thông tin phiếu mượn hiện tại
        $borrow = DB::table('borrow')->where('borrow_id', $id)->first();
        if (!$borrow) {
            return redirect()->back()->with('error', 'Không tìm thấy phiếu mượn!');
        }

        // Lấy ID của admin đang đăng nhập từ Session
        $adminId = session('admin_id') ?? session('user_id') ?? 1;

        $updateData = [
            'status'      => $newStatus,
            'approved_by' => $adminId,
            'updated_at'  => now(),
        ];

        if ($newStatus === 'borrowing') {
            if ($borrow->status !== 'pending') {
                return redirect()->back()->with('error', 'Chỉ có thể duyệt các phiếu đang ở trạng thái chờ duyệt!');
            }

            $details = DB::table('borrow_details')->where('borrow_id', $id)->get();
            foreach ($details as $item) {
                $book = DB::table('book')->where('book_id', $item->book_id)->first();
                if (!$book || $book->available_quantity < $item->quantity) {
                    $bookName = $book ? $book->book_name : 'Sách không tồn tại';
                    return redirect()->back()->with('error', "Không đủ sách trong kho cho đầu sách: '{$bookName}'. Còn lại: " . ($book->available_quantity ?? 0));
                }
            }

            // Nếu đủ điều kiện -> Tiến hành trừ kho từng cuốn sách
            foreach ($details as $item) {
                DB::table('book')
                    ->where('book_id', $item->book_id)
                    ->decrement('available_quantity', $item->quantity);
            }
        }

        // --- 2. XỬ LÝ KHI XÁC NHẬN "ĐÃ TRẢ SÁCH" ---
        if ($newStatus === 'returned') {
            $updateData['return_date'] = now();
            $details = DB::table('borrow_details')->where('borrow_id', $id)->get();

            // Cộng lại số lượng vào kho
            foreach ($details as $item) {
                DB::table('book')
                    ->where('book_id', $item->book_id)
                    ->increment('available_quantity', $item->quantity);
            }
        }

        // Cập nhật trạng thái chính thức vào bảng borrows
        DB::table('borrow')->where('borrow_id', $id)->update($updateData);

        return redirect()->back()->with('success', 'Cập nhật trạng thái phiếu mượn thành công!');
    }
}

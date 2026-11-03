<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowController extends Controller
{
    // trang chủ phiếu mượn
    public function index(Request $request)
    {
        self::syncOverdueBorrows();

        $userId = session('user_id');
        $activeTab = $request->input('tab', 'pending');

        $borrows = DB::table('borrow')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $borrowIds = $borrows->pluck('borrow_id');
        $details = DB::table('borrow_details')
            ->join('book', 'borrow_details.book_id', '=', 'book.book_id')
            ->whereIn('borrow_details.borrow_id', $borrowIds)
            ->select('borrow_details.*', 'book.book_name', 'book.book_image')
            ->get()
            ->groupBy('borrow_id');

        return view('client.borrows.index', compact('borrows', 'details', 'activeTab'));
    }

    public function show($id)
    {
        $userId = session('user_id');

        $borrow = DB::table('borrow')
            ->where('borrow_id', $id)
            ->where('user_id', $userId)
            ->first();
        if (!$borrow) {
            abort(404);
        }

        $details = DB::table('borrow_details')
            ->join('book', 'borrow_details.book_id', '=', 'book.book_id')
            ->where('borrow_details.borrow_id', $id)
            ->select('borrow_details.*', 'book.book_name', 'book.author', 'book.isbn', 'book.book_image', 'book.slug')
            ->get();

        return view('client.borrows.show', compact('borrow', 'details'));
    }

    public function createBorrowView(Request $request)
    {
        $userId = session('user_id');
        $bookIds = $request->input('book_ids', []);

        if (empty($bookIds)) {
            return redirect()->back()->with('error', 'Vui lòng chọn ít nhất một cuốn sách để mượn!');
        }

        if (count($bookIds) > 5) {
            return redirect()->back()->with('error', 'Bạn chỉ được chọn tối đa 5 cuốn sách!');
        }

        // Lấy thông tin chi tiết các cuốn sách dựa vào mảng book_ids đã chọn
        $books = DB::table('book')
            ->whereIn('book_id', $bookIds)
            ->get();

        return view('client.borrows.create', compact('books'));
    }

    public function store(Request $request)
    {
        $userId = session('user_id');
        $bookIds = $request->input('book_ids', []);
        $quantities = $request->input('quantities', []);
        $borrowDate = now();
        $dueDate = $request->input('due_date');
        $borrowNote = $request->input('borrow_note');

        if (empty($bookIds)) {
            return redirect()->route('client.books.favorites')->with('error', 'Không có sách nào được chọn!');
        }

        // 1. Thêm vào bảng borrow
        $borrowId = DB::table('borrow')->insertGetId([
            'user_id'      => $userId,
            'approved_by'  => null,
            'borrow_datetime'  => $borrowDate,
            'due_date'     => $dueDate,
            'return_date'  => null,
            'borrow_note'  => $borrowNote,
            'created_at'   => now(),
            'updated_at'   => now(),
        ]);

        // 2. Lưu chi tiết phiếu mượn (borrow_details)
        $detailsData = [];
        foreach ($bookIds as $bookId) {
            $qty = isset($quantities[$bookId]) ? (int)$quantities[$bookId] : 1;

            $bookInDb = DB::table('book')->where('book_id', $bookId)->first();
            $maxAvailable = $bookInDb ? $bookInDb->available_quantity : 1;
            $qty = max(1, min(3, min($qty, $maxAvailable)));

            $detailsData[] = [
                'borrow_id'  => $borrowId,
                'book_id'    => $bookId,
                'quantity'   => $qty,
            ];
        }

        DB::table('borrow_details')->insert($detailsData);

        return redirect()->route('client.books.favorites')
            ->with('success', 'Đã tạo phiếu mượn thành công! Vui lòng chờ nhân viên duyệt.');
    }

    public function cancelBorrow($id)
    {
        $userId = session('user_id');

        // Tìm phiếu mượn thuộc về user hiện tại và đang ở trạng thái Chờ duyệt
        $borrow = DB::table('borrow')
            ->where('borrow_id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$borrow) {
            return redirect()->back()->with('error', 'Không tìm thấy phiếu mượn này!');
        }

        if ($borrow->status !== 'pending') {
            return redirect()->back()->with('error', 'Chỉ có thể hủy các phiếu đang ở trạng thái chờ duyệt!');
        }

        // Cập nhật trạng thái phiếu mượn thành "Đã hủy" (hoặc bạn có thể dùng ->delete() nếu muốn xóa hẳn)
        DB::table('borrow')
            ->where('borrow_id', $id)
            ->update([
                'status' => 'rejected',
                'updated_at' => now()
            ]);

        return redirect()->back()->with('success', 'Đã hủy phiếu mượn thành công!');
    }

    public function quickCreateBorrow($bookId)
    {
        $book = DB::table('book')->where('book_id', $bookId)->first();

        if (!$book || ($book->available_quantity ?? 0) <= 0) {
            return redirect()->back()->with('error', 'Sách này hiện đã hết hàng hoặc không tồn tại!');
        }

        $books = collect([$book]);
        return view('client.borrows.create', compact('books'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Mail\BookAvailableMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ReservationController extends Controller
{
    public function index()
    {
        $userId = session('user_id');

        $reservations = DB::table('book_reservation')
            ->join('book', 'book_reservation.book_id', '=', 'book.book_id')
            ->select(
                'book_reservation.reservation_id',
                'book_reservation.reservation_date',
                'book.book_id',
                'book.book_name',
                'book.book_image',
                'book.author',
                'book.available_quantity',
                'book.slug'
            )
            ->where('book_reservation.user_id', $userId)
            ->orderBy('book_reservation.reservation_date', 'desc')
            ->paginate(10);

        return view('client.reservations.index', compact('reservations'));
    }

    // Hủy phiếu đặt trước
    public function destroy($id)
    {
        $userId = session('user_id');

        $deleted = DB::table('book_reservation')
            ->where('reservation_id', $id)
            ->where('user_id', $userId)
            ->delete();

        if ($deleted) {
            return redirect()->back()->with('success', 'Đã hủy phiếu đặt trước thành công!');
        }

        return redirect()->back()->with('error', 'Không tìm thấy phiếu đặt trước hoặc bạn không có quyền hủy!');
    }

    public function store($bookId)
    {
        $userId = session('user_id');

        // 1. Kiểm tra xem sách có tồn tại và đang hết hàng / hoặc cho phép đặt trước không
        $book = DB::table('book')->where('book_id', $bookId)->first();

        if (!$book) {
            return redirect()->back()->with('error', 'Cuốn sách này không tồn tại!');
        }

        if ($book->status == 0) {
            return redirect()->back()->with('error', 'Sách này hiện đang tạm ngưng phục vụ, không thể đặt trước!');
        }

        // 2. Kiểm tra xem user này đã đặt trước cuốn sách này mà chưa nhận/chưa hoàn thành hay chưa (tránh trùng lặp)
        $existingReservation = DB::table('book_reservation')
            ->where('user_id', $userId)
            ->where('book_id', $bookId)
            ->first();

        if ($existingReservation) {
            return redirect()->back()->with('error', 'Bạn đã có phiếu đặt trước cho cuốn sách này rồi!');
        }

        // 3. Tạo record mới vào bảng đặt trước
        DB::table('book_reservation')->insert([
            'user_id'          => $userId,
            'book_id'          => $bookId,
            'reservation_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Đặt trước sách thành công! Chúng tôi sẽ thông báo qua Gmail khi sách về kho.');
    }

    public function notifyUsersWhenBookAvailable($bookId)
    {
        $book = DB::table('book')->where('book_id', $bookId)->first();

        if (!$book || $book->available_quantity <= 0) {
            return;
        }

        $reservations = DB::table('book_reservation')
            ->join('user', 'book_reservation.user_id', '=', 'user.user_id')
            ->where('book_reservation.book_id', $bookId)
            ->select('book_reservation.*', 'user.email', 'user.student_name')
            ->get();

        // 3. Vòng lặp gửi email thông báo cho từng user
        foreach ($reservations as $reservation) {
            if (!empty($reservation->email)) {
                Mail::to($reservation->email)->send(new BookAvailableMail($book));
            }
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    public function rule()
    {
        return view('client.rule');
    }

    public function guide()
    {
        return view('client.guide');
    }

    public function index()
    {
        $latestBooks = Book::with('category')
            ->orderBy('book_id', 'desc')
            ->take(6)
            ->get();

        if (session()->has('user_id') && session()->has('role') === 'admin') {
            return view('auth.admin');
        }

        return view('auth.member', compact('latestBooks'));
    }
    // 1. Trang danh sách và Tra cứu sách
    public function books(Request $request)
    {
        $query = Book::with('category');

        // Tìm kiếm theo Tên sách, Tác giả hoặc ISBN
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function ($q) use ($keyword) {
                $q->where('book_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('author', 'LIKE', "%{$keyword}%")
                    ->orWhere('isbn', 'LIKE', "%{$keyword}%");
            });
        }

        // Lọc theo Danh mục
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Lấy danh sách phân trang (12 cuốn / trang)
        $books = $query->orderBy('book_id', 'desc')->paginate(12)->withQueryString();
        $categories = Category::all();

        return view('client.books.index', compact('books', 'categories'));
    }

    // 2. Trang Chi tiết cuốn sách
    public function showBook($slug)
    {
        $book = Book::with('category')->where('slug', $slug)->firstOrFail();

        // Lấy 4 cuốn sách liên quan cùng danh mục (trừ cuốn đang xem)
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('book_id', '!=', $book->book_id)
            ->take(4)
            ->get();

        return view('client.books.show', compact('book', 'relatedBooks'));
    }

    // sách yêu thích
    public function addToFavourite($id)
    {
        // kiểm tra sách có tồn tại trong db không
        $book = DB::table('book')->where('book_id', $id)->first();
        if (!$book) {
            return back()->with('error', 'Không tìm thấy sách này!');
        }

        $userId = session('user_id');
        $existingFavorite = DB::table('favorite')->where('user_id', $userId)->where('book_id', $id)->first();

        // nếu chưa thích thì thích, còn thích rồi thì bỏ thích
        if ($existingFavorite) {
            DB::table('favorite')
                ->where('user_id', $userId)
                ->where('book_id', $id)
                ->delete();

            return back()->with('success', 'Đã xóa khỏi danh sách yêu thích!');
        } else {
            DB::table('favorite')->insert([
                'user_id' => $userId,
                'book_id' => $id,
            ]);

            return back()->with('success', 'Đã thêm khỏi danh sách yêu thích!');
        }
    }

    public function favoriteBooks(Request $request)
    {
        $userId = session('user_id');
        $keyword = $request->input('keyword');
        $perPage = 5; // Cố định 5 item mỗi trang
        $currentPage = $request->input('page', 1); // Trang hiện tại, mặc định là 1

        // 1. Khởi tạo query kết hợp bảng favorite và book
        $query = DB::table('favorite')
            ->join('book', 'favorite.book_id', '=', 'book.book_id')
            ->where('favorite.user_id', $userId)
            ->select('book.*');

        // 2. Xử lý tìm kiếm (theo tên sách hoặc tác giả)
        if (!empty($keyword)) {
            $query->where(function ($q) use ($keyword) {
                $q->where('book.book_name', 'like', "%{$keyword}%")
                    ->orWhere('book.author', 'like', "%{$keyword}%");
            });
        }

        // 3. Tính tổng số bản ghi và tổng số trang
        $totalItems = $query->count();
        $totalPages = ceil($totalItems / $perPage);

        // Đảm bảo trang hiện tại nằm trong khoảng hợp lệ
        $currentPage = max(1, min($currentPage, $totalPages == 0 ? 1 : $totalPages));

        // 4. Lấy dữ liệu cho trang hiện tại bằng skip (offset) và take (limit)
        $offset = ($currentPage - 1) * $perPage;
        $favorites = $query->skip($offset)->take($perPage)->get();

        // 5. Trả về view kèm các biến phân trang thủ công
        return view('client.favourites.favourites', compact(
            'favorites',
            'currentPage',
            'totalPages',
            'keyword'
        ));
    }
}

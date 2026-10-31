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
        $book = DB::table('book')->where('book_id', $id);
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

        // Lấy danh sách book_id mà user này đã lưu yêu thích
        $bookIds = DB::table('favorite')
            ->where('user_id', $userId)
            ->pluck('book_id');

        // Khởi tạo query lấy thông tin các cuốn sách đó
        $query = Book::with('category')->whereIn('book_id', $bookIds);

        // Xử lý tra cứu / tìm kiếm từ khóa trong danh sách yêu thích
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);
            $query->where(function ($q) use ($keyword) {
                $q->where('book_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('author', 'LIKE', "%{$keyword}%")
                    ->orWhere('isbn', 'LIKE', "%{$keyword}%");
            });
        }

        // Phân trang 12 cuốn/trang và giữ nguyên từ khóa tìm kiếm trên URL
        $books = $query->orderBy('book_id', 'desc')->paginate(12)->withQueryString();

        return view('client.favourites.favourites', compact('books'));
    }
}

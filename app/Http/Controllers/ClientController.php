<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class ClientController extends Controller
{
    public function index()
    {
        $latestBooks = Book::with('category')
        ->orderBy('book_id', 'desc')
        ->take(6)
        ->get();

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
}

<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    // 1. DS sách kèm tìm kiếm và lọc thể loại
    public function index(Request $request)
    {
        $query = Book::with('category')->orderBy('book_id', 'desc');

        // Tìm kiếm theo từ khóa 
        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('book_name', 'LIKE', "%{$keyword}%")
                  ->orWhere('author', 'LIKE', "%{$keyword}%")
                  ->orWhere('isbn', 'LIKE', "%{$keyword}%");
            });
        }

        // Lọc theo danh mục
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->paginate(10)->withQueryString();
        $categories = Category::orderBy('category_name', 'asc')->get();

        return view('admin.books.index', compact('books', 'categories'));
    }

    // 2. Trang form thêm sách mới
    public function create()
    {
        $categories = Category::orderBy('category_name', 'asc')->get();
        return view('admin.books.create', compact('categories'));
    }

    // 3. Xử lý lưu sách mới vào CSDL
    public function store(Request $request)
    {
        $request->validate([
            'book_name' => 'required|string|max:255',
            'category_id' => 'required|exists:category,category_id',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:book,isbn',
            'total_quantity' => 'required|integer|min:1',
            'page_count' => 'nullable|integer|min:1',
            'book_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'book_name.required' => 'Tên sách không được bỏ trống!',
            'category_id.required' => 'Vui lòng chọn danh mục cho sách!',
            'author.required' => 'Tên tác giả không được bỏ trống!',
            'isbn.required' => 'Mã ISBN không được bỏ trống!',
            'isbn.unique' => 'Mã ISBN này đã tồn tại trong thư viện!',
            'total_quantity.min' => 'Số lượng sách phải lớn hơn 0!',
            'book_image.image' => 'File tải lên phải là hình ảnh!',
        ]);

        // Xử lý upload ảnh bìa
        $imagePath = null;
        if ($request->hasFile('book_image')) {
            $imagePath = $request->file('book_image')->store('books', 'public');
        }

        // Tự sinh slug Chống trùng
        $slug = Str::slug($request->book_name);
        $count = Book::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        Book::create([
            'category_id' => $request->category_id,
            'book_name' => $request->book_name,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'language' => $request->language ?? 'Tiếng Việt',
            'page_count' => $request->page_count,
            'total_quantity' => $request->total_quantity,
            'available_quantity' => $request->total_quantity, // Mới nhập thì số lượng khả dụng = tổng số lượng
            'location' => $request->location,
            'book_image' => $imagePath,
            'description' => $request->description,
            'status' => 1,  
            'slug' => $slug,
        ]);

        return redirect()->route('books.index')->with('success', 'Thêm sách vào kho thành công!');
    }

    // 4. Trang form chỉnh sửa sách
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::orderBy('category_name', 'asc')->get();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    // 5. Cập nhật thông tin sách
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        $request->validate([
            'book_name' => 'required|string|max:255',
            'category_id' => 'required|exists:category,category_id',
            'author' => 'required|string|max:255',
            'isbn' => 'required|string|unique:book,isbn,' . $id . ',book_id',
            'total_quantity' => 'required|integer|min:' . ($book->total_quantity - $book->available_quantity),
            'book_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'book_name.required' => 'Tên sách không được bỏ trống!',
            'isbn.unique' => 'Mã ISBN đã trùng với cuốn sách khác!',
        ]);

        // Nếu upload ảnh mới thì xóa ảnh cũ và lưu ảnh mới
        $imagePath = $book->book_image;
        if ($request->hasFile('book_image')) {
            if ($book->book_image && Storage::disk('public')->exists($book->book_image)) {
                Storage::disk('public')->delete($book->book_image);
            }
            $imagePath = $request->file('book_image')->store('books', 'public');
        }

        // Tính lại số lượng khả dụng khi điều chỉnh tổng số lượng
        $quantityDiff = $request->total_quantity - $book->total_quantity;
        $newAvailable = max(0, $book->available_quantity + $quantityDiff);
        $slug = Str::slug($request->book_name);

        $book->update([
            'category_id' => $request->category_id,
            'book_name' => $request->book_name,
            'author' => $request->author,
            'isbn' => $request->isbn,
            'language' => $request->language,
            'page_count' => $request->page_count,
            'total_quantity' => $request->total_quantity,
            'available_quantity' => $newAvailable,
            'location' => $request->location,
            'book_image' => $imagePath,
            'description' => $request->description,
            'status' => ($request->status == 'available' || $request->status == '1') ? 1 : 0,
            'slug' => $slug,
        ]);

        return redirect()->route('books.index')->with('success', 'Cập nhật thông tin sách thành công!');
    }

    // 6. Xóa mềm sách
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete(); // Soft delete

        return redirect()->route('books.index')->with('success', 'Đã chuyển sách vào thùng rác!');
    }
}
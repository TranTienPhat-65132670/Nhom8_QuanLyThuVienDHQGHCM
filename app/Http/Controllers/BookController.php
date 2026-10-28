<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    // Danh sách sách Admin
    public function index(Request $request)
    {
        $query = Book::with('category')->orderBy('book_id', 'desc');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('book_name', 'LIKE', "%{$keyword}%")
                  ->orWhere('author', 'LIKE', "%{$keyword}%")
                  ->orWhere('isbn', 'LIKE', "%{$keyword}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $books = $query->paginate(4)->withQueryString();
        $categories = Category::orderBy('category_name', 'asc')->get();

        return view('admin.books.index', compact('books', 'categories'));
    }

    // Form thêm sách mới
    public function create()
    {
        $categories = Category::orderBy('category_name', 'asc')->get();
        return view('admin.books.create', compact('categories'));
    }

    // Xử lý lưu sách mới
    public function store(Request $request)
    {
        $request->validate([
            'book_name'      => ['required', 'string', 'max:255'],
            'category_id'    => ['required', 'integer', Rule::exists('category', 'category_id')->whereNull('deleted_at')],
            'author'         => ['required', 'string', 'max:255'],
            'isbn'           => [
                'required', 
                'string', 
                'max:50', 
                'regex:/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/', 
                Rule::unique('book', 'isbn')->whereNull('deleted_at')
            ],
            'total_quantity' => ['required', 'integer', 'min:10'],
            'location'       => ['required', Rule::in([
                'Thư viện Trung tâm DHQG-HCM',
                'Ký túc xá Khu B Đại học Quốc gia TP.HCM'
            ])],
            'page_count'     => ['nullable', 'integer', 'min:1', 'max:10000'],
            'book_image'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ], [
            'book_name.required'      => 'Tên sách không được bỏ trống!',
            'category_id.required'    => 'Vui lòng chọn danh mục cho sách!',
            'category_id.exists'      => 'Danh mục đã chọn không hợp lệ hoặc đã bị xóa!',
            'author.required'         => 'Tên tác giả không được bỏ trống!',
            'isbn.required'           => 'Mã ISBN không được bỏ trống!',
            'isbn.regex'              => 'Mã ISBN không hợp lệ! Phải gồm 10 hoặc 13 chữ số (VD: 978-604-0-12345-6 hoặc 0321146530)!',
            'isbn.unique'             => 'Mã ISBN này đã tồn tại trong thư viện!',
            'total_quantity.required' => 'Tổng số lượng sách không được bỏ trống!',
            'total_quantity.integer'  => 'Tổng số lượng sách phải là số nguyên!',
            'total_quantity.min'      => 'Tổng số lượng sách nhập kho phải từ 10 cuốn trở lên!',
            'page_count.integer'      => 'Số trang phải là số nguyên!',
            'page_count.min'          => 'Số trang phải lớn hơn 0!',
            'location.required'       => 'Vui lòng chọn khu vực thư viện!',
            'location.in'             => 'Khu vực thư viện không hợp lệ!',
            'book_image.image'        => 'File tải lên phải là hình ảnh!',
            'book_image.mimes'        => 'Ảnh bìa phải có định dạng jpeg, png, jpg hoặc webp!',
            'book_image.max'          => 'Ảnh bìa không được vượt quá 3MB!',
        ]);

        $imagePath = null;
        $destinationPath = public_path('book');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        if ($request->hasFile('book_image')) {
            $file = $request->file('book_image');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move($destinationPath, $fileName);
            $imagePath = 'book/' . $fileName;
        }

        $baseSlug = Str::slug($request->book_name);
        $slug = $baseSlug;
        $i = 1;
        while (Book::withTrashed()->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$i}";
            $i++;
        }

        Book::create([
            'category_id'        => $request->category_id,
            'book_name'          => $request->book_name,
            'author'             => $request->author,
            'isbn'               => $request->isbn,
            'language'           => $request->language ?? 'Tiếng Việt',
            'page_count'         => $request->page_count,
            'total_quantity'     => $request->total_quantity,
            'available_quantity' => $request->total_quantity,
            'location'           => $request->location,
            'book_image'         => $imagePath,
            'description'        => $request->description,
            'status'             => 1,
            'slug'               => $slug,
        ]);

        return redirect()->route('books.index')->with('success', 'Thêm sách vào kho thành công!');
    }

    // Trang Chi tiết Sách cho Admin
    public function show($id)
    {
        $book = Book::with('category')->findOrFail($id);
        return view('admin.books.show', compact('book'));
    }

    // Form sửa sách
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::orderBy('category_name', 'asc')->get();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    // Cập nhật thông tin sách
    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // Tính số sách đang cho mượn
        $borrowedQuantity = $book->total_quantity - $book->available_quantity;
        $minAllowedQuantity = max(10, $borrowedQuantity);

        $request->validate([
            'book_name'      => ['required', 'string', 'max:255'],
            'category_id'    => ['required', 'integer', Rule::exists('category', 'category_id')->whereNull('deleted_at')],
            'author'         => ['required', 'string', 'max:255'],
            'isbn'           => [
                'required', 
                'string', 
                'max:50', 
                'regex:/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/', 
                Rule::unique('book', 'isbn')->ignore($id, 'book_id')->whereNull('deleted_at')
            ],
            'total_quantity' => ['required', 'integer', 'min:' . $minAllowedQuantity],
            'page_count'     => ['nullable', 'integer', 'min:1', 'max:10000'],
            'location'       => ['required', Rule::in([
                'Thư viện Trung tâm DHQG-HCM',
                'Ký túc xá Khu B Đại học Quốc gia TP.HCM'
            ])],
            'status'         => ['required', Rule::in(['0', '1', 0, 1])],
            'book_image'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ], [
            'book_name.required'      => 'Tên sách không được bỏ trống!',
            'author.required'         => 'Tên tác giả không được bỏ trống!',
            'isbn.required'           => 'Mã ISBN không được bỏ trống!',
            'isbn.regex'              => 'Mã ISBN không hợp lệ! Phải gồm 10 hoặc 13 chữ số (VD: 978-604-0-12345-6 hoặc 0321146530)!',
            'isbn.unique'             => 'Mã ISBN này đã trùng với cuốn sách khác!',
            'category_id.required'    => 'Vui lòng chọn danh mục cho sách!',
            'category_id.exists'      => 'Danh mục không hợp lệ hoặc đã bị xóa!',
            'total_quantity.required' => 'Tổng số lượng sách không được bỏ trống!',
            'total_quantity.integer'  => 'Tổng số lượng sách phải là số nguyên!',
            'total_quantity.min'      => $borrowedQuantity > 10 
                                         ? "Tổng số lượng không được nhỏ hơn {$borrowedQuantity} (số lượng đang có người mượn)!"
                                         : 'Tổng số lượng sách phải từ 10 cuốn trở lên!',
            'page_count.integer'      => 'Số trang phải là số nguyên!',
            'page_count.min'          => 'Số trang phải lớn hơn 0!',
            'location.required'       => 'Vui lòng chọn khu vực thư viện!',
            'location.in'             => 'Khu vực thư viện không hợp lệ!',
            'status.required'         => 'Vui lòng chọn trạng thái sách!',
            'status.in'               => 'Trạng thái sách không hợp lệ!',
            'book_image.image'        => 'File tải lên phải là hình ảnh!',
            'book_image.mimes'        => 'Ảnh bìa phải có định dạng jpeg, png, jpg hoặc webp!',
            'book_image.max'          => 'Ảnh bìa không được vượt quá 3MB!',
        ]);

        $imagePath = $book->book_image;
        $destinationPath = public_path('book');

        if ($request->hasFile('book_image')) {
            $file = $request->file('book_image');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move($destinationPath, $fileName);
            $imagePath = 'book/' . $fileName;
        }

        // Tính lại số lượng khả dụng mới 
        $quantityDiff = $request->total_quantity - $book->total_quantity;
        $newAvailable = max(0, $book->available_quantity + $quantityDiff);

        // Chống trùng slug khi sửa tên sách
        $baseSlug = Str::slug($request->book_name);
        $slug = $baseSlug;
        $i = 1;
        while (Book::withTrashed()->where('slug', $slug)->where('book_id', '!=', $id)->exists()) {
            $slug = "{$baseSlug}-{$i}";
            $i++;
        }

        $book->update([
            'category_id'        => $request->category_id,
            'book_name'          => $request->book_name,
            'author'             => $request->author,
            'isbn'               => $request->isbn,
            'language'           => $request->language,
            'page_count'         => $request->page_count,
            'total_quantity'     => $request->total_quantity,
            'available_quantity' => $newAvailable,
            'location'           => $request->location,
            'book_image'         => $imagePath,
            'description'        => $request->description,
            'status'             => (int) $request->status,
            'slug'               => $slug,
        ]);

        return redirect()->route('books.index')->with('success', 'Cập nhật thông tin sách thành công!');
    }

    // Xóa mềm sách
    public function destroy($id)
    {
        $book = Book::findOrFail($id);

        $borrowedQuantity = $book->total_quantity - $book->available_quantity;

        if ($borrowedQuantity > 0) {
            return back()->with('error', "Không thể xóa sách này vì hiện đang có {$borrowedQuantity} cuốn đang được sinh viên mượn!");
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Đã chuyển sách vào thùng rác thành công!');
    }
}
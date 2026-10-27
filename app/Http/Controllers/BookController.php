<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
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
        $galleryImages = [];
        $bookPath = public_path('book');

        if (file_exists($bookPath)) {
            $files = scandir($bookPath);
            foreach ($files as $file) {
                if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                    $galleryImages[] = 'book/' . $file;
                }
            }
        }

        return view('admin.books.create', compact('categories', 'galleryImages'));
    }

    // Xử lý lưu sách mới
    public function store(Request $request)
    {
        $request->validate([
            'book_name'      => ['required', 'string', 'max:255'],
            // Chỉ cho phép chọn danh mục chưa bị xóa mềm
            'category_id'    => ['required', Rule::exists('category', 'category_id')->whereNull('deleted_at')],
            'author'         => ['required', 'string', 'max:255'],
            // Mã ISBN duy nhất 
            'isbn'           => ['required', 'string', 'max:50', Rule::unique('book', 'isbn')->whereNull('deleted_at')],
            'total_quantity' => ['required', 'integer', 'min:10'],
            // Ép buộc chỉ 1 trong 2 khu vực thư viện
            'location'       => ['required', Rule::in([
                'Thư viện Trung tâm DHQG-HCM',
                'Ký túc xá Khu B Đại học Quốc gia TP.HCM'
            ])],
            'page_count'     => ['nullable', 'integer', 'min:1'],
            'book_image'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ], [
            'book_name.required'      => 'Tên sách không được bỏ trống!',
            'category_id.required'    => 'Vui lòng chọn danh mục cho sách!',
            'category_id.exists'      => 'Danh mục đã chọn không hợp lệ hoặc đã bị xóa!',
            'author.required'         => 'Tên tác giả không được bỏ trống!',
            'isbn.required'           => 'Mã ISBN không được bỏ trống!',
            'isbn.unique'             => 'Mã ISBN này đã tồn tại trong thư viện!',
            'total_quantity.required' => 'Tổng số lượng sách không được bỏ trống!',
            'total_quantity.integer'  => 'Tổng số lượng sách phải là số!',
            'total_quantity.min'      => 'Tổng số lượng sách nhập kho phải từ 10 cuốn trở lên!',
            'location.required'       => 'Vui lòng chọn khu vực thư viện!',
            'location.in'             => 'Khu vực thư viện không hợp lệ!',
            'book_image.image'        => 'File tải lên phải là hình ảnh!',
            'book_image.mimes'        => 'Ảnh bìa phải có định dạng jpeg, png, jpg hoặc webp!',
        ]);

        // Xử lý lưu ảnh
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
        } elseif ($request->filled('selected_image')) {
            $imagePath = $request->selected_image;
        }

        // Tự sinh slug duy nhất
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

    // Form sửa sách
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::orderBy('category_name', 'asc')->get();
        $galleryImages = [];
        $bookPath = public_path('book');

        if (file_exists($bookPath)) {
            $files = scandir($bookPath);
            foreach ($files as $file) {
                if (in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'webp', 'gif'])) {
                    $galleryImages[] = 'book/' . $file;
                }
            }
        }

        return view('admin.books.edit', compact('book', 'categories', 'galleryImages'));
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
            'category_id'    => ['required', Rule::exists('category', 'category_id')->whereNull('deleted_at')],
            'author'         => ['required', 'string', 'max:255'],
            'isbn'           => ['required', 'string', 'max:50', Rule::unique('book', 'isbn')->ignore($id, 'book_id')->whereNull('deleted_at')],
            'total_quantity' => ['required', 'integer', 'min:' . $minAllowedQuantity],
            'location'       => ['required', Rule::in([
                'Thư viện Trung tâm DHQG-HCM',
                'Ký túc xá Khu B Đại học Quốc gia TP.HCM'
            ])],
            'book_image'     => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:3072'],
        ], [
            'book_name.required'      => 'Tên sách không được bỏ trống!',
            'author.required'         => 'Tên tác giả không được bỏ trống!',
            'isbn.required'           => 'Mã ISBN không được bỏ trống!',
            'isbn.unique'             => 'Mã ISBN này đã trùng với cuốn sách khác!',
            'total_quantity.required' => 'Tổng số lượng sách không được bỏ trống!',
            'total_quantity.min'      => $borrowedQuantity > 10 
                                         ? "Tổng số lượng không được nhỏ hơn {$borrowedQuantity} (số lượng đang có người mượn)!"
                                         : 'Tổng số lượng sách phải từ 10 cuốn trở lên!',
            'location.required'       => 'Vui lòng chọn khu vực thư viện!',
            'location.in'             => 'Khu vực thư viện không hợp lệ!',
        ]);

        $imagePath = $book->book_image;
        $destinationPath = public_path('book');

        if ($request->hasFile('book_image')) {
            $file = $request->file('book_image');
            $fileName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
            $file->move($destinationPath, $fileName);
            $imagePath = 'book/' . $fileName;
        } elseif ($request->filled('selected_image')) {
            $imagePath = $request->selected_image;
        }

        // Tính lại số lượng khả dụng mới (Đã sửa phép trừ)
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
            'status'             => ($request->status == 'available' || $request->status == '1') ? 1 : 0,
            'slug'               => $slug,
        ]);

        return redirect()->route('books.index')->with('success', 'Cập nhật thông tin sách thành công!');
    }

    // Xóa mềm sách 
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        // Tính số lượng đang mượn
        $borrowedQuantity = $book->total_quantity - $book->available_quantity;

        if ($borrowedQuantity > 0) {
            return back()->with('error', "Không thể xóa sách này vì hiện đang có {$borrowedQuantity} cuốn đang được sinh viên mượn!");
        }

        $book->delete();
        return redirect()->route('books.index')->with('success', 'Đã chuyển sách vào thùng rác thành công!');
    }
}
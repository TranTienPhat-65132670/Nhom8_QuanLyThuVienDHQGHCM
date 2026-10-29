<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    // 1. Hiển thị danh sách danh mục
    public function index()
    {
        $categories = Category::withCount('books')
            ->orderBy('category_id', 'desc')
            ->paginate(5); // 👉 Cập nhật phân trang 5 dòng/trang

        return view('admin.categories.index', compact('categories'));
    }

    // 2. Thêm danh mục mới
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('category', 'category_name')->whereNull('deleted_at'),
            ],
        ], [
            'category_name.required' => 'Vui lòng nhập tên danh mục!',
            'category_name.unique'   => 'Tên danh mục này đã tồn tại trong hệ thống!',
        ]);

        Category::create([
            'category_name' => $request->category_name,
            'slug'          => Str::slug($request->category_name),
        ]);

        return redirect()->route('categories.index')->with('success', 'Thêm danh mục mới thành công!');
    }

    // 3. Cập nhật danh mục
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'category_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('category', 'category_name')
                    ->ignore($id, 'category_id')
                    ->whereNull('deleted_at'),
            ],
        ], [
            'category_name.required' => 'Tên danh mục không được để trống!',
            'category_name.unique'   => 'Tên danh mục này đã trùng với một danh mục khác!',
        ]);

        $category->update([
            'category_name' => $request->category_name,
            'slug'          => Str::slug($request->category_name),
        ]);

        return redirect()->route('categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    // 4. Xóa danh mục
    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->books()->exists()) {
            return back()->with('error', 'Không thể xóa vì danh mục này đang chứa sách!');
        }

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}
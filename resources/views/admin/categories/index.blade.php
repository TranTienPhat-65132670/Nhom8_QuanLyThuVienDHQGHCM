@extends('layout.admin')

@section('title', 'Quản Lý Danh Mục Sách')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-white p-5 rounded-2xl shadow-xs border border-slate-200">
        <div>
            <h1 class="text-xl font-bold text-slate-800">Danh Mục Sách</h1>
            <p class="text-xs text-slate-500 mt-1">Quản lý các thể loại sách trong hệ thống thư viện</p>
        </div>
        <button onclick="openCreateModal()" class="px-4 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-xl flex items-center gap-2 shadow-sm transition">
            <i class="fa-solid fa-plus"></i> Thêm Danh Mục
        </button>
    </div>

    @if(session('success'))
        <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation text-rose-500 text-sm"></i>
            {{ session('error') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-slate-200 shadow-xs overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                    <th class="p-4 w-16 text-center">STT</th>
                    <th class="p-4">Tên Danh Mục</th>
                    <th class="p-4">Đường Dẫn</th>
                    <th class="p-4 text-center">Số Lượng Sách</th>
                    <th class="p-4 text-right">Thao Tác</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-xs text-slate-700">
                @forelse($categories as $index => $category)
                    <tr class="hover:bg-slate-50/80 transition">
                        <td class="p-4 text-center font-medium text-slate-500">{{ $categories->firstItem() + $index }}</td>
                        <td class="p-4 font-bold text-slate-900">{{ $category->category_name }}</td>
                        <td class="p-4 text-slate-500 font-mono">{{ $category->slug }}</td>
                        <td class="p-4 text-center">
                            <span class="px-2.5 py-1 bg-slate-100 text-slate-700 font-semibold rounded-lg">
                                {{ $category->books_count }} cuốn
                            </span>
                        </td>
                        <td class="p-4 text-right space-x-1">
                            <button onclick="openEditModal({{ $category->category_id }}, '{{ addslashes($category->category_name) }}')"
                                    class="p-2 hover:bg-amber-50 text-amber-600 rounded-lg transition" title="Chỉnh sửa">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <!-- Nút Xóa -->
                            <form action="{{ route('categories.destroy', $category->category_id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 hover:bg-rose-50 text-rose-600 rounded-lg transition" title="Xóa">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">Chưa có danh mục nào. Hãy nhấn "Thêm Danh Mục" để tạo mới!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="p-4 border-t border-slate-100">
            {{ $categories->links() }}
        </div>
    </div>
</div>

<!-- Modal Thêm Danh Mục -->
<div id="createModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-base font-bold text-slate-800 mb-4">Thêm Danh Mục Sách</h3>
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Tên danh mục <span class="text-rose-500">*</span></label>
                <input type="text" name="category_name" required placeholder="VD: Công Nghệ Thông Tin"
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeCreateModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">Hủy</button>
                <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl">Lưu Danh Mục</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Sửa Danh Mục -->
<div id="editModal" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 shadow-xl border border-slate-100">
        <h3 class="text-base font-bold text-slate-800 mb-4">Chỉnh Sửa Danh Mục</h3>
        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-xs font-semibold text-slate-600 mb-1">Tên danh mục <span class="text-rose-500">*</span></label>
                <input type="text" id="edit_category_name" name="category_name" required
                       class="w-full px-3.5 py-2 text-xs border border-slate-200 rounded-xl focus:outline-hidden focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>
            <div class="flex justify-end gap-2 pt-2">
                <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-100 rounded-xl">Hủy</button>
                <button type="submit" class="px-4 py-2 text-xs font-semibold text-white bg-amber-600 hover:bg-amber-700 rounded-xl">Cập Nhật</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() { document.getElementById('createModal').classList.remove('hidden'); }
    function closeCreateModal() { document.getElementById('createModal').classList.add('hidden'); }
    function openEditModal(id, name) {
        document.getElementById('edit_category_name').value = name;
        document.getElementById('editForm').action = '/admin/categories/' + id;
        document.getElementById('editModal').classList.remove('hidden');
    }
    function closeEditModal() { document.getElementById('editModal').classList.add('hidden'); }
</script>
@endsection
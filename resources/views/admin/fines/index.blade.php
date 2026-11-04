@extends('layout.admin')

@section('title', 'Quản Lý Khoản Phạt')

@section('content')
    <div class="max-w-6xl mx-auto px-4 py-8">

        <!-- Thông báo thành công / lỗi -->
        @if (session('success'))
            <div class="mb-4 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm rounded-xl font-medium">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 bg-rose-50 border border-rose-200 text-rose-700 text-sm rounded-xl font-medium">
                {{ session('error') }}
            </div>
        @endif

        <!-- Tiêu đề & Nút thêm mới -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <i class="fa-solid fa-receipt text-rose-600"></i> Quản lý danh sách khoản phạt
                </h1>
                <p class="text-xs text-gray-500 mt-1">Danh sách các danh mục và mức tiền phạt vi phạm nội quy thư viện.</p>
            </div>

            <div class="flex items-center gap-3">
                <!-- Form tìm kiếm -->
                <form action="{{ route('admin.fines.index') }}" method="GET" class="flex items-center gap-2">
                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                        placeholder="Tìm kiếm khoản phạt..."
                        class="px-4 py-2 text-sm border border-gray-200 rounded-xl focus:outline-none focus:border-rose-500 bg-white shadow-xs">
                    <button type="submit"
                        class="px-4 py-2 bg-gray-800 hover:bg-gray-900 text-white text-sm font-semibold rounded-xl transition">
                        <i class="fa-solid fa-search"></i>
                    </button>
                </form>

                <!-- Nút thêm mới -->
                <a href="{{ route('admin.fines.create') }}"
                    class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold rounded-xl transition shadow-xs flex items-center gap-2 whitespace-nowrap">
                    <i class="fa-solid fa-plus"></i> Thêm khoản phạt
                </a>
            </div>
        </div>

        <!-- Bảng danh sách -->
        <div class="bg-white rounded-2xl shadow-xs border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr
                            class="bg-gray-50 text-gray-600 border-b border-gray-100 font-semibold text-xs uppercase tracking-wider">
                            <th class="py-3 px-4 text-center w-16">ID</th>
                            <th class="py-3 px-4">Tên khoản phạt</th>
                            <th class="py-3 px-4">Số tiền</th>
                            <th class="py-3 px-4">Mô tả chi tiết</th>
                            <th class="py-3 px-4 text-center w-28">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($fines as $item)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="py-3 px-4 text-center font-bold text-gray-500">#{{ $item->fine_id }}</td>
                                <td class="py-3 px-4 font-bold text-gray-800">{{ $item->fine_name }}</td>
                                <td class="py-3 px-4 font-bold text-rose-600">
                                    {{ number_format($item->fine_amount) }} VNĐ
                                </td>
                                <td class="py-3 px-4 text-gray-600 text-xs">
                                    {{ $item->description ?? 'Không có mô tả' }}
                                </td>
                                <td class="py-3 px-4 text-center">
                                    <div class="flex items-center justify-center gap-1.5">
                                        <!-- Nút Sửa -->
                                        <a href="{{ route('admin.fines.edit', $item->fine_id) }}"
                                            class="p-2 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition"
                                            title="Sửa">
                                            <i class="fa-solid fa-pen-to-square text-xs"></i>
                                        </a>
                                        <!-- Nút Xóa -->
                                        <form action="{{ route('admin.fines.destroy', $item->fine_id) }}" method="POST"
                                            onsubmit="return confirm('Bạn có chắc chắn muốn xóa khoản phạt này không?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-rose-50 hover:bg-rose-100 text-rose-600 rounded-lg transition"
                                                title="Xóa">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400 italic">
                                    Không có khoản phạt nào trong hệ thống.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- PHÂN TRANG TỰ VIẾT THỦ CÔNG (CUSTOM PAGINATION) -->
            @if ($fines->hasPages())
                <div class="flex items-center justify-between px-6 py-4 bg-gray-50/50 border-t border-gray-100">
                    <div class="text-xs text-gray-500">
                        Hiển thị từ <span class="font-bold text-gray-700">{{ $fines->firstItem() ?? 0 }}</span> đến <span
                            class="font-bold text-gray-700">{{ $fines->lastItem() ?? 0 }}</span> trong tổng số <span
                            class="font-bold text-gray-700">{{ $fines->total() }}</span> kết quả
                    </div>

                    <div class="flex items-center gap-1">
                        {{-- Nút Trang Trước --}}
                        @if ($fines->onFirstPage())
                            <span
                                class="px-3 py-1.5 text-xs font-semibold text-gray-300 bg-white border border-gray-200 rounded-lg cursor-not-allowed">
                                <i class="fa-solid fa-chevron-left mr-1"></i> Trước
                            </span>
                        @else
                            <a href="{{ $fines->previousPageUrl() }}"
                                class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                                <i class="fa-solid fa-chevron-left mr-1"></i> Trước
                            </a>
                        @endif

                        {{-- Các nút số trang --}}
                        @foreach ($fines->getUrlRange(1, $fines->lastPage()) as $page => $url)
                            @if ($page == $fines->currentPage())
                                <span
                                    class="px-3 py-1.5 text-xs font-bold text-white bg-rose-600 border border-rose-600 rounded-lg shadow-xs">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}"
                                    class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Nút Trang Sau --}}
                        @if ($fines->hasMorePages())
                            <a href="{{ $fines->nextPageUrl() }}"
                                class="px-3 py-1.5 text-xs font-semibold text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-100 transition">
                                Sau <i class="fa-solid fa-chevron-right ml-1"></i>
                            </a>
                        @else
                            <span
                                class="px-3 py-1.5 text-xs font-semibold text-gray-300 bg-white border border-gray-200 rounded-lg cursor-not-allowed">
                                Sau <i class="fa-solid fa-chevron-right ml-1"></i>
                            </span>
                        @endif
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection

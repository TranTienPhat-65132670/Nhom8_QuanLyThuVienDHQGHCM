@extends('layout.admin')

@section('title', 'Dashboard Quản Trị')

@section('content')
    <div class="container-fluid px-4 py-6">
        <!-- Tiêu đề trang & Chào mừng -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Tổng quan hệ thống</h1>
            </div>
        </div>

        <!-- 1. Hàng Thẻ Thống Kê (Stat Cards) -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Tổng số sách -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Tổng số sách</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBooks }}</h3>
                </div>
                <div class="w-12 h-12 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl">
                    <i class="fas fa-book"></i>
                </div>
            </div>

            <!-- Đang mượn -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Sách đang mượn</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $borrowingBooks }}</h3>
                </div>
                <div class="w-12 h-12 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    <i class="fas fa-bookmark"></i>
                </div>
            </div>

            <!-- Chờ duyệt -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Yêu cầu chờ duyệt</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $pendingRequests }}</h3>
                </div>
                <div class="w-12 h-12 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    <i class="fas fa-hourglass-half"></i>
                </div>
            </div>

            <!-- Thành viên -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wider text-gray-400">Thành viên</p>
                    <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalUsers }}</h3>
                </div>
                <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>

        <!-- 2. Khu vực Biểu đồ & Thống kê nhanh -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Biểu đồ chính (2 cột) -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 lg:col-span-2">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-gray-800">Thống kê mượn/trả sách</h2>
                    <select id="timeFilter"
                        class="text-sm border-gray-300 rounded-lg px-3 py-1.5 focus:ring-indigo-500 focus:border-indigo-500 cursor-pointer">
                        <option value="7days" selected>7 ngày gần nhất</option>
                        <option value="month">Tháng này (30 ngày)</option>
                        <option value="year">Năm nay (12 tháng)</option>
                    </select>
                </div>
                <div class="relative h-72">
                    <canvas id="borrowChart"></canvas>
                </div>
            </div>

            <!-- Sách được mượn nhiều nhất (1 cột) -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-800 mb-4">Top 5 sách mượn nhiều nhất</h2>
                <div class="space-y-4">
                    @forelse($top5Books as $book)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3">
                                <!-- Hiển thị ảnh sách -->
                                <div
                                    class="w-10 h-14 bg-gray-200 rounded object-cover flex items-center justify-center text-xs text-gray-500 font-bold overflow-hidden">
                                    @if (!empty($book->book_image))
                                        <img src="{{ asset($book->book_image) }}" alt="{{ $book->book_name }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        Ảnh
                                    @endif
                                </div>
                                <div>
                                    <h4 class="text-sm font-semibold text-gray-800">{{ $book->book_name }}</h4>
                                    <p class="text-xs text-gray-500">{{ $book->author ?? 'Đang cập nhật' }}</p>
                                </div>
                            </div>
                            <span class="text-xs font-semibold px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-full">
                                {{ $book->total_borrowed }}
                            </span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400 text-center py-4">Chưa có dữ liệu mượn sách.</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('borrowChart').getContext('2d');

            // Tạo hiệu ứng Gradient
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(79, 70, 229, 0.35)');
            gradient.addColorStop(1, 'rgba(79, 70, 229, 0.0)');

            // Dữ liệu ban đầu truyền từ Controller
            const initialData = @json($initialChart);

            // Khởi tạo biểu đồ
            const borrowChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: initialData.labels,
                    datasets: [{
                        label: 'Lượt mượn sách',
                        data: initialData.data,
                        borderColor: '#4F46E5',
                        backgroundColor: gradient,
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#4F46E5',
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1E293B',
                            padding: 10,
                            cornerRadius: 8
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#64748B'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0,
                                color: '#64748B'
                            },
                            grid: {
                                color: '#F1F5F9'
                            }
                        }
                    }
                }
            });

            // Xử lý sự kiện khi thay đổi mốc thời gian trên thẻ select
            document.getElementById('timeFilter').addEventListener('change', function() {
                const filterValue = this.value;

                fetch(`{{ route('admin_index') }}?filter=${filterValue}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(response => response.json())
                    .then(resData => {
                        // Cập nhật lại dữ liệu và nhãn cho Chart.js
                        borrowChart.data.labels = resData.labels;
                        borrowChart.data.datasets[0].data = resData.data;
                        borrowChart.update(); // Render lại biểu đồ mượt mà
                    })
                    .catch(error => console.error('Lỗi khi lọc biểu đồ:', error));
            });
        });
    </script>
@endsection

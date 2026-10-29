<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Thư Viện ĐHQG-HCM</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>

<body class="bg-slate-100 font-sans antialiased text-slate-800">
    <div class="flex min-h-screen relative overflow-x-hidden">
        <!-- Sidebar -->
        @include('layout.partial.admin-sidebar')

        <!-- Main Content Area -->
        <div id="main-content" class="flex-1 flex flex-col min-w-0 md:ml-64 transition-all duration-300">
            <!-- Header -->
            @include('layout.partial.admin-header')

            <!-- Page Content -->
            <main class="flex-1 p-6 md:p-3">
                <!-- Nội dung chính -->
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Tự động loại bỏ target="_blank" của tất cả nút/thẻ link trên trang để luôn mở ở TAB HIỆN TẠI
            document.querySelectorAll('a[target="_blank"]').forEach(function(link) {
                link.removeAttribute('target');
            });

            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('main-content');
            if (window.innerWidth >= 768 && localStorage.getItem('sidebarClosed') === 'true') {
                sidebar.classList.remove('md:translate-x-0');
                sidebar.classList.add('-translate-x-full');
                mainContent.classList.remove('md:ml-64');
                mainContent.classList.add('ml-0');
            }
        });

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            const mainContent = document.getElementById('main-content');

            if (window.innerWidth < 768) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            } else {
                if (sidebar.classList.contains('md:translate-x-0')) {
                    sidebar.classList.remove('md:translate-x-0');
                    sidebar.classList.add('-translate-x-full');
                    mainContent.classList.remove('md:ml-64');
                    mainContent.classList.add('ml-0');
                    localStorage.setItem('sidebarClosed', 'true');
                } else {
                    sidebar.classList.add('md:translate-x-0');
                    sidebar.classList.remove('-translate-x-full');
                    mainContent.classList.add('md:ml-64');
                    mainContent.classList.remove('ml-0');
                    localStorage.setItem('sidebarClosed', 'false');
                }
            }
        }
    </script>

    @stack('scripts')
</body>

</html>
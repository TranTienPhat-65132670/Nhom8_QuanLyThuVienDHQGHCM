<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang Chủ') - Thư Viện ĐHQG-HCM</title>

    <!-- Font Awesome 6 Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- CDN Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    @stack('styles')
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-800 flex flex-col min-h-screen">

    <!-- Header / Navbar -->
    @include('layout.partial.client-header')

    <!-- Main Content Area -->
    <main class="flex-1">

        <!-- Nội dung của từng trang thành viên -->
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layout.partial.client-footer')

    @stack('scripts')
</body>

</html>

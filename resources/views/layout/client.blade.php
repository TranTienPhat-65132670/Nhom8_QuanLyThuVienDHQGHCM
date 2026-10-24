<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang Chủ')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="images/icon_web.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .main-banner-swiper .swiper-wrapper {
            display: flex !important;
        }

        .main-banner-swiper .swiper-pagination-bullet {
            width: 14px;
            height: 14px;
            background: rgba(255, 255, 255, 0.5);
            opacity: 1;
            border: 2px solid rgba(0, 0, 0, 0.3);
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
            margin: 0 6px !important;
        }

        .main-banner-swiper .swiper-pagination-bullet-active {
            width: 32px;
            border-radius: 8px;
            background: #0d9488;
            /* Màu teal nổi bật */
            border-color: #ffffff;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-slate-50 font-sans antialiased text-slate-800 flex flex-col min-h-screen">

    <!-- Header / Navbar -->
    @include('layout.partial.client-header')

    <!-- Main Content Area -->
    <main class="flex-1">
        <!-- Content -->
        @yield('content')
    </main>

    <!-- Footer -->
    @include('layout.partial.client-footer')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    @stack('scripts')
</body>

</html>

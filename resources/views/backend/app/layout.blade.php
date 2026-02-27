<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Admin Panel</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/jpeg" href="{{ asset('assets/apex favicon.jpeg') }}">

    <!-- CDN Font Awesome 6 Free -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @stack('styles')
</head>
<body class="bg-gray-50" x-data="{ showMobileMenu: false, showUserMenu: false, openAppearance: false }">
    
    <!-- Navbar (Fixed Top) -->
    @include('backend.app.navbar')
    
    <!-- Sidebar (Fixed Left) -->
    @include('backend.app.sidebar')
    
    <!-- Main Content Area (with left padding for sidebar) -->
    <main class="ml-64 pt-16">
        @yield('content')
    </main>
    
    @stack('scripts')
</body>
</html>

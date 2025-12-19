<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Coffee Online</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Menghilangkan scrollbar default untuk sidebar agar lebih clean */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #2d2f3f;
            border-radius: 10px;
        }
    </style>
</head>
<body class="bg-[#f8f9fd]">

<div class="flex">

    {{-- Sidebar --}}
    {{-- Pastikan di dalam file ini tag <aside> memiliki class 'fixed' dan 'w-64' --}}
    @include('admin.layouts-admin.sidebar')

    {{-- Main content --}}
    {{-- Tambahkan ml-64 (margin left) agar konten tidak tertutup sidebar yang berstatus fixed --}}
    <div class="flex-1 flex flex-col ml-64 min-h-screen">
        
        @include('admin.layouts-admin.navbar')

        <main class="p-8">
            @yield('content')
        </main>
    </div>

</div>

</body>
</html>
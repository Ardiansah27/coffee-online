<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Coffee Online</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.tailwindcss.com"></script>
    {{-- Leaflet CSS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #2d2f3f; border-radius: 10px; }
    </style>
   

</head>
<body class="bg-[#f8f9fd]">

<div class="flex">
    @include('admin.layouts-admin.sidebar')

    <div class="flex-1 flex flex-col ml-64 min-h-screen">
        @include('admin.layouts-admin.navbar')

        <main class="p-8">
            @yield('content')
        </main>
    </div>
</div>

{{-- Script Inti (Hanya dipanggil sekali) --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- TEMPAT MENAMPUNG SCRIPT DARI HALAMAN LAIN --}}
@stack('scripts')
@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',          // icon sukses
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        confirmButtonColor: '#8c6239', // warna tombol sesuai tema
        background: '#fffaf6',         // warna background Swal sesuai tema
        color: '#4b2e12',              // warna teks
        width: 360
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "{{ session('error') }}",
        confirmButtonColor: '#8c6239',
        background: '#fffaf6',
        color: '#4b2e12',
        width: 360
    });
</script>
@endif

</body>
</html>
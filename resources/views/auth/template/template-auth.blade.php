<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coffee')</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen font-sans">



@yield('layout-login') {{-- Konten halaman login/register akan muncul di sini --}}
 @yield('layout-register')
 @yield('forgot')
 @yield('reset')
 

















</body>
</html>

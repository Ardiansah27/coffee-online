<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Coffee Bliss')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
</head>
<body class="bg-[#f9f5f0] text-[#4b2e12]">

  <!-- Navbar -->
  <nav class="bg-white/80 backdrop-blur-md fixed w-full z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
      <a href="{{ route('home') }}" class="text-2xl font-bold text-[#6f4e37]">☕ Coffee Bliss</a>
      <ul class="hidden md:flex space-x-6 font-medium">
        <li><a href="{{ route('home') }}" class="hover:text-[#a67b5b]">Home</a></li>
        <li><a href="{{ route('menu') }}" class="hover:text-[#a67b5b]">Menu</a></li>
        <li><a href="{{ route('legalitas') }}" class="hover:text-[#a67b5b]">Legalitas</a></li>
        <li><a href="{{ route('contact') }}" class="hover:text-[#a67b5b]">Contact Us</a></li>
        <li><a href="{{ route('profil') }}" class="hover:text-[#a67b5b]">Profil</a></li>
        <li><a href="{{ route('login') }}" class="bg-[#6f4e37] text-white px-4 py-2 rounded-lg hover:bg-[#5a3e2b]">Log In</a></li>
      </ul>
    </div>
  </nav>

  <!-- Konten halaman -->
  <main class="pt-24">
    @yield('content')
        @yield('menu')
  </main>

   

  <!-- Footer -->
  <footer class="bg-[#4b2e12] text-white py-6 text-center mt-10">
    <p>© 2025 Coffee Bliss | All Rights Reserved</p>
  </footer>

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Coffee Bliss')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body class="bg-[#f9f5f0] text-[#4b2e12]">

<!-- Navbar -->
<nav class="bg-white/80 backdrop-blur-md fixed w-full z-50 shadow-md h-[100px]">
<div class="max-w-7xl mx-auto px-4 py-1 flex flex-col justify-end h-full">
  <div class="flex justify-between items-end h-full">
    <!-- Logo -->
  <a href="{{ route('home') }}" class="py-5">
    <img src="{{ asset('uploads/logo2.png') }}" alt="Kopi Sarongge" class="h-14">
</a>


    <!-- Hamburger Menu (Mobile) -->
    <div class="md:hidden py-5">
      <button id="menu-btn" class="text-[#6f4e37] focus:outline-none">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>
    </div>
 

  <!-- Menu Desktop -->
  <ul class="hidden md:flex space-x-6 font-medium items-center justify-end py-6 text-xl ">
    <li><a href="{{ route('home') }}" class="hover:text-[#a67b5b] hover:underline hover:font-bold transition-colors duration-300">Home</a></li>
    <li><a href="{{ route('menu') }}" class="hover:text-[#a67b5b] hover:underline hover:font-bold transition-colors duration-300">Menu</a></li>
    <li><a href="{{ route('legalitas') }}" class="hover:text-[#a67b5b] hover:underline hover:font-bold transition-colors duration-300">Legalitas</a></li>
    <li><a href="{{ route('contact') }}" class="hover:text-[#a67b5b] hover:underline hover:font-bold transition-colors duration-300">Contact Us</a></li>
    <li><a href="{{ route('profil') }}" class="hover:text-[#a67b5b] hover:underline hover:font-bold transition-colors duration-300">Profil</a></li>
    <li><a href="{{ route('login') }}" class="bg-[#6f4e37] hover:underline hover:font-bold text-white px-4 py-2 rounded-lg hover:bg-[#5a3e2b] transition-colors duration-300">Log In</a></li>
  </ul>
</div>

  <!-- Mobile Menu -->
  <ul id="mobile-menu" class="md:hidden absolute top-full left-0 w-full flex-col space-y-2 px-4 pb-3 bg-white/90 backdrop-blur-md shadow-md transform -translate-y-2 opacity-0 pointer-events-none transition-all duration-300">
    <li><a href="{{ route('home') }}" class="block py-2 text-[#6f4e37] hover:text-[#a67b5b] transition-colors duration-300">Home</a></li>
    <li><a href="{{ route('menu') }}" class="block py-2 text-[#6f4e37] hover:text-[#a67b5b] transition-colors duration-300">Menu</a></li>
    <li><a href="{{ route('legalitas') }}" class="block py-2 text-[#6f4e37] hover:text-[#a67b5b] transition-colors duration-300">Legalitas</a></li>
    <li><a href="{{ route('contact') }}" class="block py-2 text-[#6f4e37] hover:text-[#a67b5b] transition-colors duration-300">Contact Us</a></li>
    <li><a href="{{ route('profil') }}" class="block py-2 text-[#6f4e37] hover:text-[#a67b5b] transition-colors duration-300">Profil</a></li>
    <li><a href="{{ route('login') }}" class="block py-2 bg-[#6f4e37] text-white rounded-lg text-center hover:bg-[#5a3e2b] transition-colors duration-300">Log In</a></li>
  </ul>
</nav>
 </div>



  <!-- Konten halaman -->
  <main class="pt-24">
    @yield('content')
        @yield('menu')
  </main>

   

  <!-- Footer -->
  <footer class="bg-[#4b2e12] text-white py-6 text-center mt-10">
    <p>© 2025 Coffee Bliss | All Rights Reserved</p>
  </footer>


  <!-- Script Toggle Mobile Menu with Transition -->
<script>
  const btn = document.getElementById('menu-btn');
  const menu = document.getElementById('mobile-menu');

  btn.addEventListener('click', () => {
    if(menu.classList.contains('opacity-0')){
      menu.classList.remove('-translate-y-2', 'opacity-0', 'pointer-events-none');
      menu.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');
    } else {
      menu.classList.add('-translate-y-2', 'opacity-0', 'pointer-events-none');
      menu.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
    }
  });
</script>



</body>
</html>

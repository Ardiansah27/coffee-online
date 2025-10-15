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

   
<br><br><br><br><br>


<footer class="bg-cover bg-center text-white pt-12 pb-6 px-6" style="background-image: url('{{ asset('uploads/footer.png') }}');">
  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-10">

    <!-- Logo & Deskripsi -->
    <div class="md:col-span-1">
      <img src="{{ asset('uploads/logo2.png') }}" alt="Kopi Sarongge" class="h-16 mb-9 drop-shadow-md">
      <p class="text-sm leading-relaxed text-gray-200">
        Tempat terbaik menikmati kopi alami di kaki gunung, ditemani hawa sejuk dan batu alam yang menenangkan.
      </p>
    </div>

  <!-- Navigasi -->
<div >
  <h4 class="text-lg font-semibold mb-4 text-yellow-300">Navigasi</h4>
  <ul class="space-y-4 text-sm text-gray-200">
    <li><a href="{{ route('home') }}" class="hover:text-yellow-400 transition">Home</a></li>
    <li><a href="{{ route('menu') }}" class="hover:text-yellow-400 transition">Menu</a></li>
    <li><a href="{{ route('contact') }}" class="hover:text-yellow-400 transition">Contact</a></li>
    <li><a href="{{ route('legalitas') }}" class="hover:text-yellow-400 transition">Legalitas</a></li>
  </ul>
</div>


    <!-- Kontak -->
    <div>
      <h4 class="text-lg font-semibold mb-4 text-yellow-300">Kontak Kami</h4>
      <p class="text-sm text-gray-200">
        Jl. Raya Sarongge No. 99<br>
        Cianjur, Jawa Barat 43252<br>
        Indonesia
      </p>
      <p class="mt-2 text-sm text-gray-200">📞 (0263) 123-456</p>
      <p class="text-sm text-gray-200">✉️ info@saronggecoffee.com</p>
    </div>

    <!-- Peta Lokasi -->
    <div>
      <h4 class="text-lg font-semibold mb-4 text-yellow-300">Peta Lokasi</h4>
      <div class="rounded-xl overflow-hidden shadow-md border border-white/10">
        <iframe
          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.471366239993!2d107.1234567!3d-6.1234567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6851dfdfd!2sSarongge%20Coffee!5e0!3m2!1sen!2sid!4v1234567890"
          width="100%"
          height="200"
          style="border:0;"
          allowfullscreen=""
          loading="lazy"
          referrerpolicy="no-referrer-when-downgrade"></iframe>
      </div>
    </div>

  </div>

  <!-- Garis dan Copyright -->
  <div class="mt-10 text-center text-sm text-gray-300 border-t border-white/20 pt-4">
    &copy; {{ date('Y') }} <span class="text-yellow-200 font-semibold">Coffee Sarongge</span>. All rights reserved.
  </div>
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

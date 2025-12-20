<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Coffee Sarongge')</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">

<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
</head>
<body class="bg-[#f9f5f0] text-[#4b2e12] overflow-x-hidden">

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
<ul class="hidden md:flex space-x-6 font-medium items-center justify-end py-6 text-xl w-full">

    @guest
        <!-- Guest hanya bisa lihat Home, Menu, dan Log In -->
        <li><a href="{{ route('landing') }}" class="hover:text-[#a67b5b] hover:underline hover:font-bold transition-colors duration-300">Home</a></li>
        <li><a href="{{ route('menu') }}" class="hover:text-[#a67b5b] hover:underline hover:font-bold transition-colors duration-300">Menu</a></li>
        <li>
            <a href="{{ route('login') }}" class="bg-[#6f4e37] hover:underline hover:font-bold text-white px-4 py-2 rounded-lg hover:bg-[#5a3e2b] transition-colors duration-300">
                Log In
            </a>
        </li>
    @endguest

    @auth
        <!-- User login tetap sama seperti sekarang -->
        <li><a href="{{ route('home') }}" class="hover:text-[#a67b5b] hover:underline hover:font-bold transition-colors duration-300">Home</a></li>
        <li><a href="{{ route('menu') }}" class="hover:text-[#a67b5b] hover:underline hover:font-bold transition-colors duration-300">Menu</a></li>
        <li><a href="{{ route('legalitas') }}" class="hover:text-[#a67b5b] hover:underline hover:font-bold transition-colors duration-300">Legalitas</a></li>
        <li><a href="{{ route('contact') }}" class="hover:text-[#a67b5b] hover:underline hover:font-bold transition-colors duration-300">Contact Us</a></li>
        <li><a href="{{ route('profil') }}" class="hover:text-[#a67b5b] hover:underline hover:font-bold transition-colors duration-300">Profil</a></li>

        <div class="flex items-center justify-end gap-4 ml-auto">
            <!-- Keranjang -->
        <li>
    <a href="{{ route('troli') }}" class="relative flex items-center hover:text-[#a67b5b] transition-colors duration-300">
        
        <img src="{{ asset('uploads/keranjang.png') }}" alt="Keranjang" class="w-11 h-11">

        @auth
            @php
                $count = \App\Models\Cart::where('user_id', auth()->id())->count();
            @endphp
            
            @if($count > 0)
              <span class="cart-badge absolute -top-1 -right-1 bg-red-600 text-white text-[10px] font-bold rounded-full w-5 h-5 flex items-center justify-center border-2 border-white shadow-sm {{ $count == 0 ? 'hidden' : '' }}">
    {{ $count }}
</span>
            @endif
        @endauth
        
    </a>
</li>

            <!-- Logout -->
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-[#6f4e37] hover:underline hover:font-bold text-white px-4 py-2 rounded-lg hover:bg-[#5a3e2b] transition-colors duration-300">
                        Logout
                    </button>
                </form>
            </li>
        </div>
    @endauth

</ul>


<!-- mobile -->
<ul id="mobile-menu" class="md:hidden absolute top-full left-0 w-full flex-col space-y-1 px-4 pb-6 bg-white/95 backdrop-blur-lg shadow-xl border-t border-gray-100 transform -translate-y-2 opacity-0 pointer-events-none transition-all duration-300 rounded-b-2xl">
    
    @guest
        <div class="pt-4 pb-2 border-b border-gray-100 mb-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest px-2">Main Menu</p>
        </div>
        <li><a href="{{ route('landing') }}" class="flex items-center px-3 py-3 text-[#6f4e37] hover:bg-[#6f4e37]/5 rounded-xl transition-all duration-300 font-medium">Home</a></li>
        <li><a href="{{ route('menu') }}" class="flex items-center px-3 py-3 text-[#6f4e37] hover:bg-[#6f4e37]/5 rounded-xl transition-all duration-300 font-medium">Menu</a></li>
        <li class="pt-2">
            <a href="{{ route('login') }}" class="block w-full py-3 bg-[#6f4e37] text-white rounded-xl text-center font-bold shadow-lg shadow-[#6f4e37]/20 active:scale-95 transition-all duration-300">
                Log In
            </a>
        </li>
    @endguest

    @auth
        <div class="pt-4 pb-2 border-b border-gray-100 mb-2 flex items-center justify-between px-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">User Menu</p>
            <span class="text-[10px] text-[#6f4e37] font-medium bg-[#6f4e37]/10 px-2 py-0.5 rounded-full">Member</span>
        </div>

        <li><a href="{{ route('home') }}" class="flex items-center px-3 py-3 text-[#6f4e37] hover:bg-[#6f4e37]/5 rounded-xl transition-all duration-300 font-medium">Home</a></li>
        <li><a href="{{ route('menu') }}" class="flex items-center px-3 py-3 text-[#6f4e37] hover:bg-[#6f4e37]/5 rounded-xl transition-all duration-300 font-medium">Explore Menu</a></li>
        <li><a href="{{ route('profil') }}" class="flex items-center px-3 py-3 text-[#6f4e37] hover:bg-[#6f4e37]/5 rounded-xl transition-all duration-300 font-medium">Profil Saya</a></li>
        
        <li>
            <a href="{{ route('troli') }}" class="flex items-center justify-between px-3 py-3 bg-[#6f4e37]/5 rounded-xl text-[#6f4e37] hover:bg-[#6f4e37]/10 transition-all duration-300 group">
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <img src="{{ asset('uploads/keranjang.png') }}" alt="Keranjang" class="w-6 h-6 group-hover:scale-110 transition-transform">
                        @php $count = \App\Models\Cart::where('user_id', auth()->id())->count(); @endphp
                        @if($count > 0)
                            <span class="cart-badge absolute -top-1.5 -right-1.5 bg-red-500 text-white text-[9px] font-bold rounded-full w-4 h-4 flex items-center justify-center border border-white">
    {{ $count }}
</span>
                        @endif
                    </div>
                    <span class="font-medium">Keranjang Belanja</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
            </a>
        </li>

        <div class="pt-4 pb-2 border-b border-gray-100 my-2 px-2">
            <p class="text-[10px] font-bold text-gray-400 uppercase tracking-widest">Lainnya</p>
        </div>
        <li><a href="{{ route('legalitas') }}" class="flex items-center px-3 py-2 text-[#6f4e37]/80 hover:text-[#6f4e37] transition-all">Legalitas</a></li>
        <li><a href="{{ route('contact') }}" class="flex items-center px-3 py-2 text-[#6f4e37]/80 hover:text-[#6f4e37] transition-all">Hubungi Kami</a></li>

        <li class="pt-4">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-3 border-2 border-[#6f4e37] text-[#6f4e37] rounded-xl text-center font-bold hover:bg-[#6f4e37] hover:text-white active:scale-95 transition-all duration-300">
                    Log Out
                </button>
            </form>
        </li>
    @endauth
</ul>
</nav>
</div>




  <!-- Konten halaman -->
  <main class="overflow-x-hidden">
@yield('landing') 
     @yield('content')
        @yield('menu')
        @yield('profil')
  </main>




   
<footer class="mt-10 bg-cover bg-center text-white pt-12 pb-6 px-6 mt-5" style="background-image: url('{{ asset('uploads/footer.png') }}');">
  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-12 items-start">

    <!-- Logo & Deskripsi -->
    <div class="flex flex-col items-center md:items-start text-center md:text-left">
      <img src="{{ asset('uploads/logo2.png') }}" alt="Kopi Sarongge" class="h-20 w-130 mb-6 drop-shadow-md">
      <p class="text-xl leading-relaxed text-gray-200">
        Tempat terbaik menikmati kopi alami di kaki gunung, ditemani hawa sejuk dan batu alam yang menenangkan.
      </p>
    </div>

   <!-- Navigasi -->
<div class="flex flex-col items-center md:items-start text-center md:text-left md:ml-24">
  <h1 class="text-lg font-semibold mb-4 text-yellow-300 uppercase tracking-wide">
    Navigasi
  </h1>
  <ul class="space-y-2 text-lg text-gray-200">
    <li><a href="{{ route('home') }}" class="hover:text-yellow-400 transition">Home</a></li>
    <li><a href="{{ route('menu') }}" class="hover:text-yellow-400 transition">Menu</a></li>
    <li><a href="{{ route('contact') }}" class="hover:text-yellow-400 transition">Contact</a></li>
    <li><a href="{{ route('legalitas') }}" class="hover:text-yellow-400 transition">Legalitas</a></li>

  </ul>
</div>



    <!-- Kontak -->
    <div class="flex flex-col items-center md:items-start text-center md:text-left">
      <h1 class="text-lg font-semibold mb-4 text-yellow-300 uppercase tracking-wide">Kontak Kami</h1>
      <p class="text-lg text-gray-200 leading-relaxed">
        Jl. Raya Sarongge No. 99<br>
        Cianjur, Jawa Barat 43252<br>
        Indonesia
      </p>
      <div class="mt-3 space-y-1 text-lg text-gray-200">
        <p>📞 (0263) 123-456</p>
        <p>✉️ devanzulfangga.com</p>
      </div>
    </div>

   <!-- Peta Lokasi -->
<div class="flex flex-col items-center text-center h-full">
  <!-- Judul di tengah -->
  <h1 class="text-lg font-semibold mb-4 text-yellow-300 uppercase tracking-wide">
    Peta Lokasi
  </h1>

  <!-- Map -->
  <div class="rounded-xl overflow-hidden shadow-md border border-white/10 w-full max-w-[600px]">
    <iframe
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.471366239993!2d107.1234567!3d-6.1234567!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e6851dfdfd!2sSarongge%20Coffee!5e0!3m2!1sen!2sid!4v1234567890"
      class="w-full h-[150px] md:h-[150px] lg:h-[150px]"
      style="border:0;"
      allowfullscreen=""
      loading="lazy"
      referrerpolicy="no-referrer-when-downgrade">
    </iframe>
  </div>
</div>

  </div>

  <!-- Garis dan Copyright -->
  <div class="mt-8 text-center text-sm text-gray-300 border-t border-white/20 ">
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





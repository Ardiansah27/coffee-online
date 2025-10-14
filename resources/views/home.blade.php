@extends('landing-page.landing-page')

@section('title', 'Home - Coffee Sarongge')

@section('content')
  <!-- Hero Section -->
  <section class="h-screen bg-cover bg-center flex items-center justify-center" style="background-image: url('{{ asset('assets/img/coffee-bg.jpg') }}');">
    <div class="text-center text-white bg-black/40 p-10 rounded-xl">
      <h1 class="text-5xl font-bold mb-4">Savor the Perfect Brew!</h1>
      <p class="text-lg mb-6">Rasakan kenikmatan kopi terbaik dari biji pilihan dengan cita rasa khas.</p>
      <a href="{{ route('menu') }}" class="bg-[#6f4e37] px-6 py-3 rounded-lg text-white font-semibold hover:bg-[#5a3e2b]">Lihat Menu</a>
    </div>
  </section>

  <!-- Features Section -->
  <section class="py-16 bg-[#fff7f0] text-center">
    <h2 class="text-3xl font-bold mb-8 text-[#6f4e37]">Our Featured Coffee</h2>
    <div class="grid md:grid-cols-4 gap-6 max-w-6xl mx-auto px-4">
      <div>
        <img src="{{ asset('assets/img/espresso.jpg') }}" alt="Espresso" class="rounded-xl shadow-md mb-3">
        <h3 class="font-semibold">Espresso</h3>
      </div>
      <div>
        <img src="{{ asset('assets/img/latte.jpg') }}" alt="Latte" class="rounded-xl shadow-md mb-3">
        <h3 class="font-semibold">Latte</h3>
      </div>
      <div>
        <img src="{{ asset('assets/img/cappuccino.jpg') }}" alt="Cappuccino" class="rounded-xl shadow-md mb-3">
        <h3 class="font-semibold">Cappuccino</h3>
      </div>
      <div>
        <img src="{{ asset('assets/img/coldbrew.jpg') }}" alt="Cold Brew" class="rounded-xl shadow-md mb-3">
        <h3 class="font-semibold">Cold Brew</h3>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section class="py-16 text-center bg-[#f9f5f0]">
    <div class="max-w-3xl mx-auto px-4">
      <h2 class="text-3xl font-bold mb-4 text-[#6f4e37]">Why Choose Us?</h2>
      <p class="text-gray-600">Kami menggunakan biji kopi berkualitas tinggi dan proses roasting sempurna untuk menghadirkan cita rasa terbaik di setiap cangkirnya.</p>
    </div>
  </section>
@endsection

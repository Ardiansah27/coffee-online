@extends('landing-page.landing-page')

@section('title', 'Home - Coffee Sarongge')

@section('content')

<!-- Hero Section -->

<section class="h-screen bg-cover bg-center flex justify-end items-start pt-40 md:pt-52" 
         style="background-image: url('{{ asset('uploads/back.jpg') }}');">
  <div class="text-center md:text-right text-white px-6 sm:px-10 md:mr-24 lg:mr-40 max-w-3xl mt-10">

    <!-- Judul -->
    <h1 class="text-5xl sm:text-5xl md:text-7xl lg:text-6xl font-bold leading-tight tracking-widest drop-shadow-lg"
        style="font-family: 'Playfair Display', serif; color: #f5f3f0;">
      COFFEE SHOP
    </h1>

    <!-- Paragraf deskripsi -->
    <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl mt-4 sm:mt-6 leading-relaxed drop-shadow"
       style="font-family: 'Lora', serif;">
      Rasakan kenikmatan seduhan kopi
    </p>
    <p class="text-lg sm:text-xl md:text-2xl lg:text-3xl leading-relaxed drop-shadow"
       style="font-family: 'Lora', serif;">
      Dari hutan yang terjaga
    </p>

    <!-- Tombol -->
    <div class="flex justify-center md:justify-end mt-8">
      <a href="{{ route('menu') }}"
         class="bg-[#6f4e37] px-6 sm:px-8 py-3 sm:py-4 rounded-lg text-white text-sm sm:text-base md:text-lg font-semibold hover:bg-[#5a3e2b] transition duration-300 shadow-md hover:shadow-lg">
        Lihat Menu
      </a>
    </div>
  </div>
</section>


<!-- Features Section -->
<section class="py-20 text-center bg-[#f7f3ef]">
  <h2 class="text-4xl font-bold mb-12 text-[#6f4e37] tracking-wide">Favorit Coffe</h2>

  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-10 max-w-7xl mx-auto px-6 text-[#4a3b2c]">

    <!-- Item -->
    <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
      <img src="{{ asset('uploads/drink.png') }}" alt="V60" class="w-32 mx-auto rounded-xl mb-4 shadow-sm">
      <h3 class="text-xl font-semibold text-[#6f4e37] mb-2">V60</h3>
      <p class="text-sm leading-relaxed opacity-90">
        Seduhan manual dengan hasil bersih dan aroma kopi yang tajam. Cocok untuk kamu yang ingin menikmati keaslian rasa biji kopi.
      </p>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
      <img src="{{ asset('uploads/espresso1.png') }}" alt="Espresso" class="w-32 mx-auto rounded-xl mb-4 shadow-sm">
      <h3 class="text-xl font-semibold text-[#6f4e37] mb-2">Espresso</h3>
      <p class="text-sm leading-relaxed opacity-90">
        Konsentrat kopi pekat dengan rasa kuat dan bold. Pilihan sempurna untuk penyuka kopi hitam sejati.
      </p>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
      <img src="{{ asset('uploads/kopi-tubruk.png') }}" alt="Kopi Tubruk" class="w-32 mx-auto rounded-xl mb-4 shadow-sm">
      <h3 class="text-xl font-semibold text-[#6f4e37] mb-2">Kopi Tubruk</h3>
      <p class="text-sm leading-relaxed opacity-90">
        Cita rasa khas Indonesia yang disajikan tanpa penyaringan. Aroma dan rasa yang kuat, disukai penikmat kopi tradisional.
      </p>
    </div>

    <div class="bg-white rounded-2xl shadow-md p-6 hover:shadow-xl transition duration-300 transform hover:-translate-y-1">
      <img src="{{ asset('uploads/vietnam-drip.png') }}" alt="Vietnam Drip" class="w-32 mx-auto rounded-xl mb-4 shadow-sm">
      <h3 class="text-xl font-semibold text-[#6f4e37] mb-2">Vietnam Drip</h3>
      <p class="text-sm leading-relaxed opacity-90">
        Perpaduan unik antara kopi dan susu kental manis, menghasilkan rasa manis, lembut, dan menyenangkan.
      </p>
    </div>

  </div>
</section>


<div class="flex justify-center bg-[#f5f1ec] px-4 py-10">
  <section class="shadow-lg rounded-xl overflow-hidden flex flex-col md:flex-row w-full max-w-[75rem] mx-auto">

    <!-- Carousel Container -->
    <div class="relative bg-[#e7d4c0] md:w-1/2 w-full h-64 md:h-[500px] overflow-hidden">
      <div id="carousel" class="flex w-full h-full transition-transform duration-700 ease-in-out">
        <img src="{{ asset('uploads/besseler.jpg') }}" class="w-full h-full object-cover flex-shrink-0" alt="Slide 1">
        <img src="{{ asset('uploads/slide.jpg') }}" class="w-full h-full object-cover flex-shrink-0" alt="Slide 2">
        <img src="{{ asset('uploads/slide3.jpg') }}" class="w-full h-full object-cover flex-shrink-0" alt="Slide 3">
      </div>
    </div>

    <!-- Kolom Coklat Kanan -->
    <div class="bg-[#4b2e12] text-white flex flex-col justify-center items-center md:w-1/2 w-full px-6 py-10 md:px-8 md:py-12 text-center">
      <h2 class="text-3xl md:text-5xl font-bold mb-3 leading-snug">From Bean<br>to Cup</h2>
      <p class="text-xs md:text-sm text-[#e7d4c0] mb-2">Perjalanan rasa dari kebun ke meja kamu</p>
      <p class="text-xs md:text-sm text-gray-300 mb-6 max-w-md leading-relaxed px-2">
        Kami menanam, merawat, dan memanggang biji kopi pilihan dari tanah terbaik Nusantara.  
        Setiap cangkir adalah hasil kerja tangan petani dan dedikasi kami untuk menghadirkan cita rasa kopi yang jujur, hangat, dan berkelanjutan.
      </p>
      <a href="https://kopisarongge.com/" target="_blank" rel="noopener noreferrer"
         class="bg-white text-[#4b2e12] font-semibold px-5 py-2.5 md:px-6 md:py-3 rounded-full shadow hover:shadow-md hover:bg-[#f0eae4] transition inline-block text-center text-sm md:text-base">
        Explore Now
      </a>
    </div>

  </section>
</div>



  


<br><br><br><br>

<section class="bg-gradient-to-br from-[#4b2e12] via-[#a86b3a] to-[#8b5e34] py-24 px-6 md:px-20 flex flex-col md:flex-row items-start justify-between gap-12 text-white mb-36">
  <!-- Kiri: Teks & Tombol -->
  <div class="md:w-2/5 space-y-5">
    <h4 class="text-yellow-300 text-sm font-semibold flex items-center gap-2">
      <span class="text-lg">☕</span> Caffeine Smile
    </h4>
    <h2 class="text-4xl md:text-5xl font-extrabold leading-tight">
      Morning Bliss in Every Sip
    </h2>
    <p class="text-[#f8e9d9] text-base leading-relaxed">
      Setiap tegukan membawa kehangatan dan ketenangan. Temukan rasa yang bercerita, aroma yang menenangkan, dan momen kopi yang sempurna untuk memulai harimu.
    </p>
    <div class="pt-4 flex gap-4">
     <a href="{{ route('menu') }}" 
   class="border border-yellow-300 text-yellow-300 font-semibold px-8 py-3 rounded-full 
          hover:bg-yellow-200 hover:text-[#5a3d27] transition-all duration-300 inline-block">
    Lihat Semua
</a>

    </div>
  </div>

  <!-- Kanan: Kartu Kopi -->
  <div class="md:w-3/5 grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-6">
    @foreach($day_coffe as $index => $home)
      @php
          $imageNames = ['slide.jpg', 'americanoo.png', 'besseler.jpg', 'VV60.png'];
          $image = $imageNames[$index % count($imageNames)];
      @endphp

      <div class="bg-white/95 rounded-2xl shadow-lg overflow-hidden text-center transform hover:-translate-y-2 hover:shadow-2xl transition-all duration-300">
        <img src="{{ asset('uploads/' . $image) }}" alt="Coffee Image" class="w-full h-44 object-cover">
        <div class="p-4">
          <h4 class="text-base font-semibold text-[#3b2f2f]">{{ $home->title }}</h4>
        </div>
      </div>
    @endforeach
  </div>
</section>










  <script>
  const carousel = document.getElementById("carousel");
  const totalSlides = carousel.children.length;
  let index = 0;

  setInterval(() => {
    index = (index + 1) % totalSlides;
    carousel.style.transform = `translateX(-${index * 100}%)`;
  }, 3000); // Ganti slide tiap 3 detik
</script>

@endsection

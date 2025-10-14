@extends('landing-page.landing-page')

@section('title', 'Home - Coffee Sarongge')

@section('content')

<!-- Hero Section -->


<section class="h-screen bg-cover bg-center flex justify-end items-start pt-52" style="background-image: url('{{ asset('uploads/back.jpg') }}');">
  <div class="text-left md:text-end text-white px-4 mr-4 md:mr-32 lg:mr-40">
    
    <!-- Gaya vintage kopi -->
    <h1 class="text-6xl md:text-8xl font-bold whitespace-nowrap tracking-wider" style="font-family: 'Playfair Display', serif; color: #f5f3f0;">
      COFFEE SHOP
    </h1>

    <!-- Paragraf deskripsi -->
   <p class="text-2xl md:text-3xl mt-6 text-center md:text-end" style="font-family: 'Lora', serif;">
  Rasakan kenikmatan Seduhan Kopi
</p>
<p class="text-2xl md:text-3xl text-center md:text-end" style="font-family: 'Lora', serif;">
  Dari Hutang Yang Terjaga
</p>

    <!-- Tombol di tengah -->
    <div class="flex justify-center md:justify-end mt-6">
      <a href="{{ route('menu') }}"
         class="bg-[#6f4e37] px-6 py-3 rounded-lg text-white font-semibold hover:bg-[#5a3e2b] transition duration-300">
        Lihat Menu
      </a>
    </div>

  </div>
</section>

<!-- Features Section -->
<section class="py-20 text-center bg-[#f7f3ef]">
  <h2 class="text-4xl font-bold mb-12 text-[#6f4e37] tracking-wide">Our Featured Coffee</h2>

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
  <section class="shadow-lg rounded-xl overflow-hidden flex flex-col md:flex-row w-full max-w-[90rem] mx-auto">

    <!-- Carousel Container -->
    <div class="relative bg-[#e7d4c0] md:w-1/2 h-[500px] overflow-hidden">
      <div id="carousel" class="flex w-full h-full transition-transform duration-700 ease-in-out">
        <img src="{{ asset('uploads/besseler.jpg') }}" class="w-full h-full object-cover flex-shrink-0" alt="Slide 1">
        <img src="{{ asset('uploads/slide.jpg') }}" class="w-full h-full object-cover flex-shrink-0" alt="Slide 2">
        <img src="{{ asset('uploads/slide3.jpg') }}" class="w-full h-full object-cover flex-shrink-0" alt="Slide 3">
      </div>
    </div>

    <!-- Kolom Coklat Kanan -->
    <div class="bg-[#4b2e12] text-white flex flex-col justify-center items-center md:w-1/2 px-8 py-12 text-center">
      <h2 class="text-4xl md:text-5xl font-bold mb-3 leading-snug">Why Choose<br>Us?</h2>
      <p class="text-sm text-[#e7d4c0] mb-2">Tingkat kualitas terbaik</p>
      <p class="text-sm text-gray-300 mb-6 max-w-md">
        Kami menyajikan kopi terbaik dari biji pilihan yang diproses secara profesional dan berkelanjutan — menghadirkan rasa autentik dalam setiap tegukan.
      </p>
      <button class="bg-white text-[#4b2e12] font-semibold px-6 py-3 rounded-full shadow hover:shadow-md hover:bg-[#f0eae4] transition">
        Explore Now
      </button>
    </div>

  </section>
</div>









  <!-- About Section -->
  <section class="py-16 text-center bg-[#f9f5f0]">
    <div class="max-w-3xl mx-auto px-4">
      <h2 class="text-3xl font-bold mb-4 text-[#6f4e37]">Why Choose Us?</h2>
      <p class="text-gray-600">Kami menggunakan biji kopi berkualitas tinggi dan proses roasting sempurna untuk menghadirkan cita rasa terbaik di setiap cangkirnya.</p>
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

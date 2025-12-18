@extends('landing-page.landing-page')

@section('title', 'Menu - Coffee Sarongge')

@section('menu')
<!-- Hero Section -->
<section 
    class="relative bg-cover bg-center bg-no-repeat text-white py-24 text-center mt-22"
    style="background-image: url('{{ asset('uploads/bac-menu.png') }}');">
    
    <!-- Overlay transparan warna coklat pekat -->
    <div class="absolute inset-0 bg-[#2e1c13]/70"></div>

    <div class="relative max-w-4xl mx-auto px-6 mt-10">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-5 tracking-wide drop-shadow-lg text-[#f5deb3]">
            Temukan Rasa Sejati Dalam Setiap Seduhan
        </h1>

        <p class="text-lg md:text-xl mb-10 text-[#f9e4bc] font-light leading-relaxed">
            Dari biji kopi pilihan hingga racikan sempurna — nikmati harmoni rasa, aroma, dan ketenangan di setiap tegukan.
        </p>

        <a href="#menu-section" 
           class="bg-[#f5deb3] text-[#3e2723] px-8 py-3 rounded-full font-semibold 
                  hover:bg-[#e0c58a] hover:scale-105 transition-all duration-300 transform shadow-md">
            Lihat Menu Kami
        </a>
    </div>
</section>



<!-- Filter kategori -->
<section class="bg-[#f9f9f9] py-8 border-b border-gray-200" id="menu-filter">
    <div class="max-w-6xl mx-auto flex flex-wrap justify-center gap-3 px-4">
        <!-- Tombol All -->
        <button data-category="All"
                class="filter-btn bg-green-900 text-white px-5 py-2 rounded-full font-medium transition">
            All
        </button>

        <!-- Tombol kategori -->
        @foreach($categories as $cat)
            <button data-category="{{ $cat }}"
                    class="filter-btn bg-white text-gray-700 border hover:bg-gray-100 px-5 py-2 rounded-full font-medium transition">
                {{ $cat }}
            </button>
        @endforeach
    </div>

    <!-- Produk -->
    <section id="menu-section" class="max-w-6xl mx-auto px-4 md:px-6 py-16">
        <h2 class="text-3xl font-bold mb-8 text-center text-[#6f4e37]">Our Menu</h2>

        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6 md:gap-8">
            @foreach($menu_coffee as $menu)
              <div 
  class="menu-item 
         bg-white 
         border-2 border-[#6f4e37]/30 
         rounded-2xl 
         shadow-[0_4px_10px_rgba(111,78,55,0.25)] 
         hover:shadow-[0_8px_20px_rgba(111,78,55,0.45)] 
         hover:border-[#6f4e37]/60
         active:shadow-[inset_0_3px_8px_rgba(111,78,55,0.5)] 
         active:border-[#6f4e37]
         transition-all duration-300 ease-in-out 
         p-3 sm:p-4 flex flex-col transform hover:-translate-y-1 active:scale-95"
                     data-id="{{ $menu->id }}"
                     data-category="{{ $menu->category }}">
                    
                   @if(auth()->check())
    <a href="{{ route('menu', $menu->id) }}" class="mb-3">
        <img src="{{ asset('uploads/'.$menu->image) }}" 
             alt="{{ $menu->name }}" 
             class="rounded-xl h-36 sm:h-48 w-full object-cover hover:scale-105 transition-transform duration-300">
    </a>
@else
    <a href="{{ route('login') }}" class="mb-3">
        <img src="{{ asset('uploads/'.$menu->image) }}" 
             alt="{{ $menu->name }}" 
             class="rounded-xl h-36 sm:h-48 w-full object-cover hover:scale-105 transition-transform duration-300">
    </a>
@endif


                    <h3 class="font-semibold text-sm sm:text-lg text-[#4b2e12] truncate mb-1 flex items-center">
                        {{ $menu->name }}
                    </h3>

                    <p class="text-xs sm:text-sm text-gray-500 mb-1">{{ $menu->category }}</p>

                    <p class="text-sm sm:text-md font-bold text-[#6f4e37] ">
                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                    </p>

                    <!-- Rating -->
                    <div class="flex items-center mb-1 rating" data-id="{{ $menu->id }}">
                        <span class="bintang text-yellow-400 cursor-pointer text-lg">&#9733;</span>
                        <span class="bintang text-yellow-400 cursor-pointer text-lg">&#9733;</span>
                        <span class="bintang text-yellow-400 cursor-pointer text-lg">&#9733;</span>
                        <span class="bintang text-yellow-400 cursor-pointer text-lg">&#9733;</span>
                        <span class="bintang text-yellow-400 cursor-pointer text-lg">&#9733;</span>
                        <span class="ml-2 text-sm text-gray-600 avg-rating">0.0</span>
                    </div>

                    <!-- Kuantitas -->
                    <div class="flex items-center gap-2 mb-3">
                        <button class="btn-minus px-2 py-1 bg-gray-200 rounded">-</button>
                        <span class="qty px-2">1</span>
                        <button class="btn-plus px-2 py-1 bg-gray-200 rounded">+</button>
                    </div>

                    <!-- Order -->
                 @if(auth()->check())
    <button
        class="btn-beli 
               bg-[#6f4e37] text-white 
               text-center 
               py-1.5 sm:py-2 
               rounded-lg 
               text-xs sm:text-sm
               transition 
               duration-200 
               ease-out
               transform
               hover:scale-105
               active:scale-95
               hover:bg-[#5a3e2b]
               focus:outline-none">
        Order Now
    </button>
@else
    <a href="{{ route('login') }}"
       class="bg-[#6f4e37] text-white 
              text-center 
              py-1.5 sm:py-2 
              rounded-lg 
              text-xs sm:text-sm
              transition 
              duration-200 
              ease-out
              transform
              hover:scale-105
              active:scale-95
              hover:bg-[#5a3e2b]
              focus:outline-none
              block">
        Order Now
    </a>
@endif

                </div>
            @endforeach
        </div>
    </section>
</section>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    // === FILTER KATEGORI ===
    const buttons = document.querySelectorAll('.filter-btn');
    const items = document.querySelectorAll('.menu-item');

    buttons.forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.dataset.category;
            buttons.forEach(b => {
                b.classList.remove('bg-green-900', 'text-white');
                b.classList.add('bg-white', 'text-gray-700', 'border');
            });
            this.classList.add('bg-green-900', 'text-white');
            this.classList.remove('bg-white', 'text-gray-700');

            items.forEach(item => {
                item.style.display = (category === 'All' || item.dataset.category === category)
                    ? 'flex' : 'none';
            });
        });
    });

    // === KUANTITAS PRODUK ===
    document.querySelectorAll('.menu-item').forEach(card => {
        const qtySpan = card.querySelector('.qty');
        const btnMinus = card.querySelector('.btn-minus');
        const btnPlus = card.querySelector('.btn-plus');
        let qty = parseInt(qtySpan.textContent);

        btnMinus.addEventListener('click', () => {
            qty = Math.max(1, qty - 1);
            qtySpan.textContent = qty;
        });

        btnPlus.addEventListener('click', () => {
            qty++;
            qtySpan.textContent = qty;
        });
    });

    // === SISTEM RATING PRODUK ===
    const ratings = JSON.parse(localStorage.getItem('ratings') || '{}');
    const updateAvg = (id) => {
        const data = ratings[id] || [];
        const avg = data.length ? (data.reduce((a,b)=>a+b,0) / data.length).toFixed(1) : "0.0";
        const avgSpan = document.querySelector(`.rating[data-id="${id}"] .avg-rating`);
        if (avgSpan) avgSpan.textContent = avg;
    };

    document.querySelectorAll('.rating').forEach(rateBox => {
        const id = rateBox.dataset.id;
        updateAvg(id);

        rateBox.querySelectorAll('.bintang').forEach((b, idx) => {
            b.addEventListener('click', () => {
                if (!ratings[id]) ratings[id] = [];
                ratings[id].push(idx + 1);
                localStorage.setItem('ratings', JSON.stringify(ratings));
                updateAvg(id);
                alert(`Terima kasih! Anda memberi rating ${idx + 1} bintang.`);
            });
        });
    });


</script>

<!-- Scroll Halus -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const link = document.querySelector('a[href^="#menu-section"]');
    if (link) {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                window.scrollTo({
                    top: target.offsetTop - 50,
                    behavior: 'smooth'
                });
            }
        });
    }
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pastikan klik tombol order tidak ikut trigger link
    const orderButtons = document.querySelectorAll('.btn-beli');
    orderButtons.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.stopPropagation(); // hentikan propagasi klik
        });
    });
});
</script>


@endsection

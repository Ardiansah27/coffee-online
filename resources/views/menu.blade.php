@extends('landing-page.landing-page')

@section('title', 'Menu - Coffee Sarongge')

@section('menu')
<!-- Hero Section -->
<section 
    class="relative bg-cover bg-center bg-no-repeat text-white py-24 text-center mt-22"
    style="background-image: url('{{ asset('uploads/bac-menu.png') }}');">
    
    <div class="absolute inset-0 bg-[#2e1c13]/70"></div>

    <div class="relative max-w-4xl mx-auto px-6 mt-10">
        <h1 class="text-4xl md:text-5xl font-extrabold mb-5 tracking-wide drop-shadow-lg text-[#f5deb3]">
            Temukan Rasa Sejati Dalam Setiap Seduhan
        </h1>
        <p class="text-lg md:text-xl mb-10 text-[#f9e4bc] font-light leading-relaxed">
            Dari biji kopi pilihan hingga racikan sempurna — nikmati harmoni rasa, aroma, dan ketenangan di setiap tegukan.
        </p>
        <a href="#menu-section" 
           class="bg-[#f5deb3] text-[#3e2723] px-8 py-3 rounded-full font-semibold hover:bg-[#e0c58a] hover:scale-105 transition-all duration-300 transform shadow-md inline-block">
            Lihat Menu Kami
        </a>
    </div>
</section>



<!-- Filter kategori -->
<section class="bg-[#f9f9f9] py-8 border-b border-gray-200" id="menu-filter">
    <div class="max-w-6xl mx-auto flex flex-wrap justify-center gap-3 px-4">
        <button data-category="All"
                class="filter-btn bg-[#6f4e37] text-white px-5 py-2 rounded-full font-medium transition">
            All
        </button>

        @foreach($categories as $cat)
            <button data-category="{{ $cat }}"
                    class="filter-btn bg-white text-gray-700 border hover:bg-gray-100 px-5 py-2 rounded-full font-medium transition">
                {{ $cat }}
            </button>
        @endforeach
    </div>
</section>

  <section id="menu-section" class="max-w-6xl mx-auto px-4 md:px-6 py-16">
    <h2 class="text-3xl font-bold mb-12 text-center text-[#6f4e37]">Our Menu</h2>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
        
        @foreach($menu_coffee as $menu)
        <div class="menu-item bg-white border-2 border-[#6f4e37]/20 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 p-3 sm:p-4 flex flex-col h-full transform hover:-translate-y-1"
             data-id="{{ $menu->id }}"
             data-category="{{ $menu->category }}">
            
            <a href="{{ auth()->check() ? route('menu', $menu->id) : route('login') }}" class="mb-3 block overflow-hidden rounded-xl bg-gray-50 h-36 sm:h-48">
                <img src="{{ asset('images/menu/'.$menu->image) }}" 
                     alt="{{ $menu->name }}" 
                     class="w-full h-full object-contain hover:scale-110 transition-transform duration-500">
            </a>

            <div class="flex-1">
                <h3 class="font-bold text-sm sm:text-base text-[#4b2e12] truncate mb-1">
                    {{ $menu->name }}
                </h3>
                <p class="text-sm sm:text-md font-extrabold text-[#6f4e37] mb-2">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </p>

                <div class="flex items-center mb-3 rating" data-id="{{ $menu->id }}">
                    <div class="flex text-yellow-400 text-xs sm:text-sm">
                        <span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span><span>&#9733;</span>
                    </div>
                    <span class="ml-2 text-[10px] sm:text-xs text-gray-400 font-medium">0.0</span>
                </div>

             <div class="flex items-center gap-2 mb-4">
    <button type="button" class="btn-minus ...">-</button>
    <span class="qty qty-val text-sm font-semibold w-4 text-center">1</span>
    <button type="button" class="btn-plus ...">+</button>
</div>
            </div>

     <div class="flex items-center gap-2 mt-auto">
<form class="add-to-cart-form m-0" data-id="{{ $menu->id }}">
    @csrf
    <button type="submit" class="cart-btn-click flex items-center justify-center w-10 h-10 border-2 border-[#6f4e37] rounded-lg hover:bg-[#6f4e37]/10 transition">
        <img src="{{ asset('uploads/keranjang.png') }}" alt="Cart" class="cart-icon-source w-5 h-5">
    </button>
</form>

    @if(auth()->check())
        <button class="btn-beli flex-1 bg-[#6f4e37] text-white text-center py-2 rounded-lg text-xs sm:text-sm font-bold hover:bg-[#5a3e2b] transition active:scale-95 shadow-md">
            Order
        </button>
    @else
        <a href="{{ route('login') }}" class="flex-1 bg-[#6f4e37] text-white text-center py-2 rounded-lg text-xs sm:text-sm font-bold hover:bg-[#5a3e2b] transition block">
            Order
        </a>
    @endif
</div>
        </div>
        @endforeach

    </div>
</section>
 
<script>
document.querySelectorAll('.add-to-cart-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const menuId = this.getAttribute('data-id');
        const token = this.querySelector('input[name="_token"]').value;
        
        // --- AMBIL NILAI KUANTITAS DARI CARD INI ---
        const card = this.closest('.menu-item'); // Pastikan div pembungkus utama punya class 'menu-item'
        const qtyValue = card.querySelector('.qty-val').innerText;

        // 1. LOGIKA ANIMASI TERBANG (Tetap Dipertahankan)
        const iconSource = this.querySelector('.cart-icon-source');
        const cartTarget = document.querySelector('.cart-badge');

        if (iconSource && cartTarget) {
            const flyIcon = iconSource.cloneNode(true);
            const startRect = iconSource.getBoundingClientRect();
            const endRect = cartTarget.getBoundingClientRect();

            Object.assign(flyIcon.style, {
                position: 'fixed',
                top: `${startRect.top}px`,
                left: `${startRect.left}px`,
                width: `${startRect.width}px`,
                height: `${startRect.height}px`,
                zIndex: '9999',
                transition: 'all 0.9s cubic-bezier(0.42, 0, 0.58, 1)',
                pointerEvents: 'none'
            });

            document.body.appendChild(flyIcon);

            setTimeout(() => {
                Object.assign(flyIcon.style, {
                    top: `${endRect.top}px`,
                    left: `${endRect.left}px`,
                    width: '15px',
                    height: '15px',
                    opacity: '0.3',
                    transform: 'scale(1.5) rotate(360deg)'
                });
            }, 50);

            setTimeout(() => { flyIcon.remove(); }, 900);
        }

        // 2. KIRIM DATA KE LARAVEL (Sekarang Mengirim Kuantitas)
        fetch(`/cart/add/${menuId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json', // Tambahkan ini agar Laravel tahu ini JSON
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ 
                quantity: qtyValue // MENGIRIM ANGKA 2, 3, dst
            })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                setTimeout(() => {
                    document.querySelectorAll('.cart-badge').forEach(badge => {
                        badge.innerText = data.cartCount;
                        badge.classList.remove('hidden');
                        
                        // Efek Bounce Navbar
                        badge.parentElement.classList.add('animate-bounce');
                        setTimeout(() => badge.parentElement.classList.remove('animate-bounce'), 1000);
                    });
                }, 800);
            }
        })
        .catch(err => console.error('Error:', err));
    });
});
</script>

<!-- JavaScript -->
<script>
// === FILTER KATEGORI DENGAN FADE ===
const buttons = document.querySelectorAll('.filter-btn');
const items = document.querySelectorAll('.menu-item');

buttons.forEach(btn => {
    btn.addEventListener('click', function() {
        const category = this.dataset.category;

        // Toggle style tombol aktif
        buttons.forEach(b => {
            b.classList.remove('bg-green-900', 'text-white');
            b.classList.add('bg-white', 'text-gray-700', 'border');
        });
        this.classList.add('bg-green-900', 'text-white');
        this.classList.remove('bg-white', 'text-gray-700');

        // Filter menu dengan fade
        items.forEach(item => {
            if (category === 'All' || item.dataset.category === category) {
                item.style.display = 'flex';
                setTimeout(() => item.classList.remove('opacity-0'), 10); // fade in
            } else {
                item.classList.add('opacity-0'); // fade out
                setTimeout(() => item.style.display = 'none', 300); // setelah fade selesai
            }
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

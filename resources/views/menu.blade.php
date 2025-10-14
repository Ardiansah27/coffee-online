@extends('landing-page.landing-page')

@section('title', 'Menu - Coffee Sarongge')

@section('menu')
<!-- Hero Section -->
<section class="bg-green-900 text-white py-16 text-center">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">Summer’s Brightest New Drinks</h1>
        <p class="text-lg mb-6">Discover our refreshing coffee and special blends this season.</p>
        <a href="#menu-section" class="bg-white text-green-900 px-6 py-3 rounded-full font-semibold hover:bg-gray-100 transition">
            Order Now
        </a>
    </div>
</section>

<!-- Category Tabs -->
<section class="bg-[#f9f9f9] py-8 border-b border-gray-200">
    <div class="max-w-6xl mx-auto flex flex-wrap justify-center gap-3 px-4">
        <button class="px-5 py-2 rounded-full bg-green-900 text-white font-medium hover:bg-green-800 transition">Cold Brew</button>
        <button class="px-5 py-2 rounded-full bg-white text-gray-700 border hover:bg-gray-100">Latte</button>
        <button class="px-5 py-2 rounded-full bg-white text-gray-700 border hover:bg-gray-100">Espresso</button>
        <button class="px-5 py-2 rounded-full bg-white text-gray-700 border hover:bg-gray-100">Cappuccino</button>
        <button class="px-5 py-2 rounded-full bg-white text-gray-700 border hover:bg-gray-100">Mocha</button>
        <button class="px-5 py-2 rounded-full bg-white text-gray-700 border hover:bg-gray-100">Others</button>
    </div>
</section>

<!-- Menu Section -->
<section id="menu-section" class="max-w-6xl mx-auto px-6 py-16">
    <h2 class="text-3xl font-bold mb-8 text-center text-[#6f4e37]">Our Menu</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        {{-- Looping menu dari database --}}
     @foreach($menu_coffe as $menu)

            <div class="bg-white border rounded-2xl shadow-sm hover:shadow-md transition p-4">
                <img src="{{ asset('uploads/'.$menu->image) }}" alt="{{ $menu->name }}" class="rounded-xl h-48 w-full object-cover mb-4">
                
                <h3 class="font-semibold text-lg text-[#4b2e12]">{{ $menu->name }}</h3>
                <p class="text-sm text-gray-500 mb-2">{{ $menu->category }}</p>
                <p class="text-md font-bold text-[#6f4e37] mb-4">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>

                <button 
                    onclick="window.location.href='{{ route('login') }}'"
                    class="bg-[#6f4e37] w-full text-white py-2 rounded-lg hover:bg-[#5a3e2b] transition">
                    Order Now
                </button>
            </div>
        @endforeach
    </div>
</section>
@endsection

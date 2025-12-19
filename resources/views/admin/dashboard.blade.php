@extends('admin.layouts-admin.app')

@section('content')
<div class="container mx-auto">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
        <p class="text-gray-500 text-sm">Selamat datang kembali, Admin! Berikut ringkasan data hari ini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between text-brown-600">
        <div>
            <h3 class="text-gray-400 text-sm font-medium uppercase">Total Menu</h3>
            <p class="text-4xl font-bold mt-1">{{ $totalMenu }}</p>
        </div>
        <div class="text-3xl">☕</div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between text-brown-600">
        <div>
            <h3 class="text-gray-400 text-sm font-medium uppercase">Kategori</h3>
            <p class="text-4xl font-bold mt-1">{{ $totalCategory }}</p>
        </div>
        <div class="text-3xl">📂</div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between text-brown-600">
        <div>
            <h3 class="text-gray-400 text-sm font-medium uppercase">Admin</h3>
            <p class="text-4xl font-bold mt-1">{{ $totalAdmin }}</p>
        </div>
        <div class="text-3xl">👤</div>
    </div>
</div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-50 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800">Menu Terbaru Ditambahkan</h3>
            <a href="{{ route('admin.menu') }}" class="text-indigo-600 text-sm font-semibold hover:underline">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Produk</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase">Harga</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @php
                        // Mengambil 5 menu terbaru
                        $recentMenus = \App\Models\Menu::latest()->take(5)->get();
                    @endphp
                    
                    @forelse($recentMenus as $menu)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-gray-100 overflow-hidden">
                                @if($menu->image)
                                    <img src="{{ asset('images/menu/'.$menu->image) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-[10px] text-gray-400">N/A</div>
                                @endif
                            </div>
                            <span class="font-semibold text-gray-700">{{ $menu->name }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-indigo-50 text-indigo-600 rounded-md text-xs font-medium">
                                {{ $menu->category }}
                            </span>
                        </td>
                        <td class="px-6 py-4 font-medium text-gray-700">
                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-10 text-center text-gray-400">Belum ada data menu.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
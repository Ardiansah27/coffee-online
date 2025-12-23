@extends('admin.layouts-admin.app')

@section('content')
<div class="p-6 bg-[#fdfaf7] min-h-screen">
    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="text-2xl font-bold text-[#6f4e37]">Daftar Pesanan Kopi</h1>
                <p class="text-sm text-stone-500">Kelola pesanan pelanggan dan perbarui status pengiriman.</p>
            </div>
            <span class="bg-stone-200 text-stone-600 px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-widest">
                Total: {{ $orders->count() }} Pesanan
            </span>
        </div>

        <div class="grid gap-6">
            @forelse($orders as $order)
                <div class="bg-white rounded-2xl shadow-sm border border-stone-100 overflow-hidden transition-all hover:shadow-md">
                    {{-- Header Pesanan --}}
                    <div class="p-4 border-b bg-stone-50/50 flex flex-wrap justify-between items-center gap-4">
                        <div class="flex items-center gap-4">
                            <div class="bg-[#6f4e37] text-white p-3 rounded-xl">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 text-lg">{{ $order->order_number }}</h3>
                                <p class="text-xs text-stone-400">{{ $order->created_at->format('d M Y, H:i') }} WIB</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            {{-- Badge Status --}}
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-orange-100 text-orange-600',
                                    'processing' => 'bg-blue-100 text-blue-600',
                                    'completed' => 'bg-green-100 text-green-600',
                                    'cancelled' => 'bg-red-100 text-red-600',
                                ]
                            @endphp
                            <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-widest {{ $statusClasses[$order->status] ?? 'bg-gray-100' }}">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>

                    {{-- Konten Detail --}}
                    <div class="p-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
                        {{-- Info Pelanggan & Alamat --}}
                        <div class="space-y-4">
                            <h4 class="text-[10px] font-bold text-stone-400 uppercase tracking-widest border-b pb-2">Informasi Pengiriman</h4>
                            <div>
                                <p class="font-bold text-gray-800">{{ $order->user->name }}</p>
                                <p class="text-sm text-stone-500">{{ $order->user->email }}</p>
                            </div>
                            <div class="bg-stone-50 p-3 rounded-xl border border-stone-100">
                                <p class="text-xs text-stone-600 leading-relaxed italic">
                                    {{ $order->alamat->alamat_lengkap ?? 'Alamat tidak ditemukan' }}
                                </p>
                            </div>
                        </div>

                        {{-- Daftar Item (Kopi) --}}
                        <div class="space-y-4">
                            <h4 class="text-[10px] font-bold text-stone-400 uppercase tracking-widest border-b pb-2">Produk Yang Dibeli</h4>
                            <div class="space-y-3">
                                @foreach($order->items as $item)
                                    <div class="flex items-center gap-3">
                                        <img src="{{ asset('images/menu/' . ($item->menu->image ?? '')) }}" 
                                             class="w-12 h-12 object-cover rounded-lg border border-stone-100" 
                                             onerror="this.src='{{ asset('images/default-coffee.jpg') }}'">
                                        <div class="flex-1">
                                            <p class="text-sm font-bold text-gray-800">{{ $item->menu->name ?? 'Menu Terhapus' }}</p>
                                            <p class="text-[10px] text-stone-400">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- Rincian Biaya & Aksi --}}
                        <div class="space-y-4">
                            <h4 class="text-[10px] font-bold text-stone-400 uppercase tracking-widest border-b pb-2">Pembayaran ({{ $order->payment_method }})</h4>
                            <div class="space-y-1 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-stone-400">Subtotal</span>
                                    <span class="text-gray-600 font-medium">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-stone-400">Ongkir</span>
                                    <span class="text-gray-600 font-medium">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between pt-2 border-t mt-2">
                                    <span class="font-bold text-gray-800">Total</span>
                                    <span class="font-black text-[#6f4e37] text-lg">Rp {{ number_format($order->total_pembayaran, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            {{-- Form Update Status --}}
                            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" class="pt-4">
                                @csrf
                                @method('PATCH')
                                
                                @if($order->status == 'pending')
                                    <input type="hidden" name="status" value="processing">
                                    <button type="submit" class="w-full bg-[#6f4e37] text-white py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-[#5a3f2d] transition-all flex items-center justify-center gap-2 shadow-lg shadow-stone-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                        Siapkan Kopi
                                    </button>
                                @elseif($order->status == 'processing')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-xl font-bold text-xs uppercase tracking-widest hover:bg-green-700 transition-all flex items-center justify-center gap-2">
                                        Kirim / Selesai
                                    </button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-stone-200">
                    <p class="text-stone-400 italic">Belum ada pesanan masuk hari ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
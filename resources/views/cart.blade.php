@extends('landing-page.landing-page')

@section('content')
<div class="min-h-screen bg-[#fdfaf7] py-10 px-4">
    <div class="max-w-4xl mx-auto">
        
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('menu') }}" class="p-2 bg-white rounded-full shadow-sm hover:bg-gray-100 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-[#6f4e37]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-[#6f4e37]">Troli Sarongge</h1>
        </div>

        @if($cart_items->isEmpty())
            <div class="bg-white rounded-3xl p-10 text-center shadow-sm border border-gray-100">
                <img src="{{ asset('uploads/keranjang.png') }}" alt="Kosong" class="w-32 h-32 mx-auto mb-4 opacity-20">
                <p class="text-gray-500 text-lg mb-6">Wah, troli kamu masih kosong nih.</p>
                <a href="{{ route('menu') }}" class="inline-block bg-[#6f4e37] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#5a3e2b] transition">
                    Cari Kopi Sekarang
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-4">
                    @foreach($cart_items as $item)
                        <div class="bg-white rounded-2xl p-4 shadow-sm border border-gray-50 border-b-4 border-b-[#6f4e37]/20 flex items-center gap-4">
                            <div class="w-20 h-20 bg-gray-50 rounded-xl overflow-hidden shrink-0">
                                <img src="{{ asset('images/menu/' . $item->menu->image) }}" 
     alt="{{ $item->menu->name }}" 
     class="w-full h-full object-contain p-2">
                            </div>

                            <div class="flex-1">
                                <h3 class="font-bold text-[#6f4e37] text-lg">{{ $item->menu->name }}</h3>
                                <p class="text-sm text-gray-400 mb-2">Harga Satuan: Rp {{ number_format($item->menu->price, 0, ',', '.') }}</p>
                                
                                <div class="flex items-center justify-between">
                             
                              <div class="flex items-center bg-gray-100 rounded-lg p-1">
    <button type="button" 
            class="change-qty w-8 h-8 flex items-center justify-center hover:bg-white rounded-md transition font-bold text-gray-600" 
            data-id="{{ $item->id }}" 
            data-action="minus">
        -
    </button>
    
    <span id="qty-{{ $item->id }}" 
          class="qty-val px-4 font-bold text-sm" 
          data-price="{{ $item->menu->price }}">
        {{ $item->quantity }}
    </span>
    
    <button type="button" 
            class="change-qty w-8 h-8 flex items-center justify-center hover:bg-white rounded-md transition font-bold text-gray-600" 
            data-id="{{ $item->id }}" 
            data-action="plus">
        +
    </button>
</div>
                                    
                                    <form action="{{ route('troli.remove', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600 p-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl p-6 shadow-md border border-gray-100 sticky top-10">
                        <h2 class="text-xl font-bold text-[#6f4e37] mb-4">Ringkasan Pesanan</h2>
                        
                      <div class="space-y-3 mb-6">
    <div class="flex justify-between text-gray-500">
        <span>Total Item</span>
        <span id="total-item">{{ $cart_items->sum('quantity') }}</span>
    </div>
    <div class="flex justify-between font-bold text-lg border-t pt-3 mt-3 text-[#6f4e37]">
        <span>Total Bayar</span>
        <span id="total-bayar">Rp {{ number_format($cart_items->sum(fn($i) => $i->quantity * $i->menu->price), 0, ',', '.') }}</span>
    </div>
</div>

                        <button class="w-full bg-[#6f4e37] text-white py-4 rounded-2xl font-bold shadow-lg shadow-[#6f4e37]/20 hover:bg-[#5a3e2b] transition active:scale-95">
                            Checkout Sekarang
                        </button>
                        
                        <p class="text-[10px] text-gray-400 text-center mt-4 italic">
                            *Harga sudah termasuk pajak & kenangan manis.
                        </p>
                    </div>
                </div>

            </div>
        @endif
    </div>
</div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Fungsi hitung total di kanan (Ringkasan)
    function refreshSummary() {
        let total = 0;
        let items = 0;
        document.querySelectorAll('.qty-val').forEach(s => {
            let q = parseInt(s.innerText);
            let p = parseInt(s.getAttribute('data-price'));
            items += q;
            total += (q * p);
        });
        
        if(document.getElementById('total-item')) document.getElementById('total-item').innerText = items;
        if(document.getElementById('total-bayar')) {
            document.getElementById('total-bayar').innerText = 'Rp ' + new Intl.NumberFormat('id-ID').format(total);
        }
    }

    // Ambil semua tombol dengan class change-qty
    const qtyButtons = document.querySelectorAll('.change-qty');
    
    qtyButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const action = this.dataset.action;
            const span = document.getElementById(`qty-${id}`);
            let current = parseInt(span.innerText);

            // Logika angka
            if (action === 'plus' && current < 10) current++;
            else if (action === 'minus' && current > 1) current--;
            else return;

            // Update layar
            span.innerText = current;
            refreshSummary();

            // Update database lewat AJAX
            fetch(`/cart/update/${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ quantity: current })
            })
            .then(res => res.json())
            .then(data => {
                if(!data.success) alert('Gagal update keranjang');
            })
            .catch(err => console.error('Error:', err));
        });
    });
});
</script>
@extends('landing-page.landing-page')

@section('content')
<div class="min-h-screen bg-[#fdfaf7] py-10 px-4">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-2xl font-bold text-[#6f4e37] mb-8 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Konfirmasi Pesanan
        </h1>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Kolom Kiri: Alamat & Produk --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Kotak Alamat --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-[#6f4e37]">
                    <div class="flex justify-between items-start mb-4">
                        <h3 class="font-bold text-[#6f4e37] flex items-center gap-2 uppercase text-xs tracking-wider">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                            </svg>
                            Alamat Pengiriman
                        </h3>
                        <button type="button" onclick="openAddressModal()" class="text-[#6f4e37] text-sm font-bold hover:underline">
                            Ubah Alamat
                        </button>
                    </div>

                    <div id="active-address-display" class="text-sm text-gray-600">
    @if($selected_address)
        <p class="font-bold text-gray-800 text-base mb-1">
            {{ $selected_address->nama_penerima }} | {{ $selected_address->no_telepon }}
        </p>
        <p class="leading-relaxed">
            {{ $selected_address->alamat_lengkap }}, {{ $selected_address->kota }}, {{ $selected_address->provinsi }}
        </p>
        <input type="hidden" name="alamat_id" id="selected-address-id" value="{{ $selected_address->id }}">
    @else
        <div class="py-4 text-center border-2 border-dashed border-gray-100 rounded-xl">
            <p class="text-red-500 italic mb-2">Belum ada alamat pengiriman dipilih.</p>
            <button type="button" onclick="openAddressModal()" class="text-[#6f4e37] font-bold text-sm hover:underline">+ Pilih Alamat</button>
        </div>
    @endif
</div>
                </div>

                {{-- List Produk (Placeholder - Sesuaikan dengan data keranjang Anda) --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <h3 class="font-bold text-gray-800 mb-4">Produk Pesanan</h3>
                    {{-- Loop produk di sini --}}
                </div>
            </div>

            {{-- Kolom Kanan: Rincian Pembayaran --}}
            <div class="lg:col-span-1">
                <div class="bg-white p-6 rounded-3xl shadow-lg border border-gray-50 sticky top-10">
                    <h3 class="font-bold text-[#6f4e37] mb-6 border-b pb-4">Rincian Pembayaran</h3>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Subtotal Produk</span>
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Ongkos Kirim</span>
                            <span id="display-ongkir" class="font-medium text-gray-800">Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Diskon Voucher</span>
                            <span class="text-green-500">- Rp 0</span>
                        </div>
                        <hr class="border-dashed my-4">
                        <div class="flex justify-between font-bold text-xl text-[#6f4e37]">
                            <span>Total</span>
                            <span id="display-total">Rp {{ number_format($total_pembayaran, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="#" method="POST">
                        @csrf
                        <input type="hidden" name="alamat_id" id="final-alamat-id" value="{{ $selected_address->id ?? '' }}">
                        <button type="submit" class="w-full bg-[#6f4e37] text-white py-4 rounded-2xl font-black shadow-xl shadow-[#6f4e37]/20 hover:bg-[#3c2a1e] hover:-translate-y-1 transition-all active:scale-95 uppercase tracking-widest text-sm">
                            Buat Pesanan Sekarang
                        </button>
                    </form>
                    
                    <p class="text-[10px] text-center text-gray-400 mt-4 px-4 leading-tight italic">
                        Dengan menekan tombol di atas, Anda setuju dengan Syarat & Ketentuan Kopi Sarongge.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL ALAMAT ALA SHOPEE --}}
<div id="addressModal" class="fixed inset-0 bg-black/60 hidden z-[9999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl flex flex-col max-h-[85vh]">
        <div class="p-4 border-b flex justify-between items-center bg-white sticky top-0">
            <h3 class="font-bold text-lg text-gray-800">Alamat Saya</h3>
            <button onclick="closeAddressModal()" class="text-gray-400 hover:text-red-500 text-2xl transition-colors">&times;</button>
        </div>
        
        <div class="p-4 overflow-y-auto space-y-3 flex-1 bg-gray-50">
           @foreach($user_addresses as $addr)
<div class="border-2 rounded-xl p-4 cursor-pointer transition-all relative group bg-white mb-3 {{ ($selected_address && $selected_address->id == $addr->id) ? 'border-[#6f4e37] ring-1 ring-[#6f4e37]' : 'border-transparent hover:border-stone-200 shadow-sm' }}"
     onclick="selectAddress({
        id: '{{ $addr->id }}',
        nama_penerima: '{{ $addr->nama_penerima }}',
        no_telepon: '{{ $addr->no_telepon }}',
        alamat_lengkap: '{{ $addr->alamat_lengkap }}',
        kota: '{{ $addr->kota }}',
        provinsi: '{{ $addr->provinsi }}',
        jarak: '{{ $addr->jarak }}'
     })">
    
    <div class="flex items-center gap-2 mb-1">
        <span class="font-bold text-sm text-gray-800">{{ $addr->nama_penerima }}</span>
        <span class="text-gray-300 text-sm">|</span>
        <span class="text-gray-500 text-sm">{{ $addr->no_telepon }}</span>
    </div>
    
    <p class="text-xs text-gray-500 leading-relaxed pr-8">
        {{ $addr->alamat_lengkap }}, {{ $addr->kota }}, {{ $addr->provinsi }}
    </p>

    {{-- Label Alamat (Rumah/Kantor) --}}
    <span class="mt-2 inline-block text-[10px] bg-stone-100 text-stone-500 px-2 py-0.5 rounded-sm font-bold uppercase group-hover:bg-[#6f4e37] group-hover:text-white transition-colors">
        {{ $addr->label_alamat }}
    </span>

    @if($selected_address && $selected_address->id == $addr->id)
    <div class="absolute top-4 right-4 text-[#6f4e37]">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
    </div>
    @endif
</div>
@endforeach
        </div>

        <div class="p-4 border-t bg-white">
            <button type="button" 
                    onclick="window.location.href='{{ route('profil.alamat.create') }}'"
                    class="w-full flex items-center justify-center gap-2 py-3 border-2 border-dashed border-gray-200 rounded-xl text-gray-600 font-bold text-sm hover:bg-stone-50 hover:border-[#6f4e37] hover:text-[#6f4e37] transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Alamat Baru
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function openAddressModal() {
    document.getElementById('addressModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden'; // Stop scroll background
}

function closeAddressModal() {
    document.getElementById('addressModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}
function selectAddress(address) {
    // 1. Update Tampilan di Halaman Utama
    const display = document.getElementById('active-address-display');
    display.innerHTML = `
        <p class="font-bold text-gray-800 text-base mb-1">${address.nama_penerima} | ${address.no_telepon}</p>
        <p class="leading-relaxed">${address.alamat_lengkap}, ${address.kota}, ${address.provinsi}</p>
        <input type="hidden" name="alamat_id" id="selected-address-id" value="${address.id}">
    `;

    // 2. Update Ongkir (Sesuai Logika Anda)
    const tarifPerKm = 2000;
    const jarak = parseFloat(address.jarak) || 0;
    let jarakHitung = jarak > 7 ? 7 : jarak;
    const ongkirBaru = Math.round(jarakHitung * tarifPerKm);
    
    const subtotal = {{ $subtotal }};
    const totalBaru = subtotal + ongkirBaru;

    // 3. Update Visual Angka
    document.getElementById('display-ongkir').innerText = `Rp ${ongkirBaru.toLocaleString('id-ID')}`;
    document.getElementById('display-total').innerText = `Rp ${totalBaru.toLocaleString('id-ID')}`;

    // 4. Tutup Modal
    closeAddressModal();
}
</script>
@endsection
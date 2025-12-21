@extends('landing-page.landing-page')

@section('content')
<div class="min-h-screen bg-[#fdfaf7] py-10 px-4">
    <div class="max-w-5xl mx-auto">
        <h1 class="text-2xl font-bold text-[#6f4e37] mb-8 flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Konfirmasi Pesanan
        </h1>

     <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-[#6f4e37]">
    <div class="flex justify-between items-start mb-4">
        <h3 class="font-bold text-[#6f4e37] flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
            </svg>
            Alamat Pengiriman
        </h3>
        <button type="button" onclick="openAddressModal()" class="text-blue-500 text-sm font-bold hover:underline">
            Ubah Alamat
        </button>
    </div>

    <div id="active-address-display" class="text-sm text-gray-600">
        @if($selected_address)
            <p class="font-bold text-gray-800">{{ Auth::user()->name }} | {{ $selected_address->phone }}</p>
            <p>{{ $selected_address->detail_alamat }}, {{ $selected_address->kota }}, {{ $selected_address->provinsi }}</p>
            <input type="hidden" name="alamat_id" id="selected-address-id" value="{{ $selected_address->id }}">
        @else
            <p class="text-red-500 italic">Belum ada alamat. Silakan tambah alamat di profil.</p>
        @endif
    </div>
</div>

<div id="addressModal" class="fixed inset-0 bg-black/50 hidden z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-3xl w-full max-w-lg overflow-hidden shadow-2xl">
        <div class="p-6 border-b flex justify-between items-center">
            <h3 class="font-bold text-lg text-[#6f4e37]">Pilih Alamat Pengiriman</h3>
            <button onclick="closeAddressModal()" class="text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
        </div>
        
        <div class="p-6 max-h-[400px] overflow-y-auto space-y-4">
            @foreach($user_addresses as $addr)
            <div class="border-2 rounded-2xl p-4 cursor-pointer hover:border-[#6f4e37] transition @if($selected_address && $selected_address->id == $addr->id) border-[#6f4e37] bg-[#fdfaf7] @else border-gray-100 @endif"
                 onclick="selectAddress({{ json_encode($addr) }})">
                <p class="font-bold text-sm">{{ Auth::user()->name }} | {{ $addr->phone }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $addr->detail_alamat }}, {{ $addr->kota }}, {{ $addr->provinsi }}</p>
            </div>
            @endforeach
            
            <a href="{{ route('profil') }}" class="block text-center text-[#6f4e37] font-bold text-sm mt-4 border-2 border-dashed border-[#6f4e37]/30 p-4 rounded-2xl hover:bg-[#fdfaf7]">
                + Tambah Alamat Baru
            </a>
        </div>
    </div>
</div>

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
    <span id="display-ongkir">Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
</div>
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Diskon Voucher</span>
                            <span class="text-green-500">- Rp 0</span>
                        </div>
                        <hr class="border-dashed my-4">
                      <div class="flex justify-between font-bold text-lg text-[#6f4e37]">
    <span>Total Pembayaran</span>
    <span id="display-total">Rp {{ number_format($total_pembayaran, 0, ',', '.') }}</span>
</div>
                    </div>

                    <button class="w-full bg-[#6f4e37] text-white py-4 rounded-2xl font-bold shadow-lg shadow-[#6f4e37]/20 hover:bg-[#5a3e2b] transition active:scale-95">
                        Buat Pesanan Sekarang
                    </button>
                    
                    <p class="text-[10px] text-center text-gray-400 mt-4 px-4 leading-tight italic">
                        Dengan menekan tombol di atas, Anda setuju dengan Syarat & Ketentuan Kopi Sarongge.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

<script>
function openAddressModal() {
    document.getElementById('addressModal').classList.remove('hidden');
}

function closeAddressModal() {
    document.getElementById('addressModal').classList.add('hidden');
}

function selectAddress(address) {
    // 1. Update tampilan Nama & Alamat
    const display = document.getElementById('active-address-display');
    display.innerHTML = `
        <p class="font-bold text-gray-800">{{ Auth::user()->name }} | ${address.phone}</p>
        <p>${address.detail_alamat}, ${address.kota}, ${address.provinsi}</p>
        <input type="hidden" name="alamat_id" id="selected-address-id" value="${address.id}">
    `;

    // 2. LOGIKA UPDATE ONGKIR OTOMATIS
    const tarifPerKm = 2000;
    const jarak = parseFloat(address.jarak) || 0; // Pastikan kolom jarak ada di data address
    const jarakHitung = jarak > 7 ? 7 : jarak; // Batasan 7km
    const ongkirBaru = jarakHitung * tarifPerKm;
    
    // Ambil subtotal dari PHP (hapus karakter titik/non-numeric)
    const subtotal = {{ $subtotal }};
    const totalBaru = subtotal + ongkirBaru;

    // 3. Update Tampilan Angka di Rincian Pembayaran
    document.getElementById('display-ongkir').innerText = `Rp ${ongkirBaru.toLocaleString('id-ID')}`;
    document.getElementById('display-total').innerText = `Rp ${totalBaru.toLocaleString('id-ID')}`;

    // 4. Tutup Modal
    closeAddressModal();
}


</script>
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
            {{-- Kolom Kiri: Alamat, Produk & Pembayaran --}}
            <div class="lg:col-span-2 space-y-6">
                
             {{-- 1. TAMPILAN ALAMAT AKTIF --}}
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

{{-- 2. MODAL PILIHAN ALAMAT (Harus ada agar JS tidak error) --}}
<div id="addressModal" class="fixed inset-0 bg-black/60 hidden z-[9999] flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="bg-white rounded-2xl w-full max-w-lg overflow-hidden shadow-2xl flex flex-col max-h-[85vh]">
        <div class="p-4 border-b flex justify-between items-center bg-white">
            <h3 class="font-bold text-[#6f4e37]">Pilih Alamat Pengiriman</h3>
            <button type="button" onclick="closeAddressModal()" class="text-gray-400 hover:text-red-500 text-2xl">&times;</button>
        </div>
        
        <div class="p-4 overflow-y-auto space-y-3 flex-1 bg-gray-50">
            @foreach($user_addresses as $addr)
                <div onclick='selectAddress(@json($addr))' 
                     class="p-4 bg-white border-2 rounded-xl cursor-pointer transition-all hover:border-[#6f4e37] {{ $selected_address && $selected_address->id == $addr->id ? 'border-[#6f4e37] bg-stone-50' : 'border-gray-100' }}">
                    <div class="flex justify-between items-start">
                        <p class="font-bold text-gray-800">{{ $addr->nama_penerima }}</p>
                        @if($addr->is_utama)
                            <span class="text-[10px] bg-[#6f4e37] text-white px-2 py-0.5 rounded">Utama</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $addr->no_telepon }}</p>
                    <p class="text-xs text-gray-600 mt-2 line-clamp-2">{{ $addr->alamat_lengkap }}</p>
                </div>
            @endforeach
        </div>
        
        <div class="p-4 border-t bg-white">
            <a href="{{ route('profil.alamat.create') }}" class="block w-full text-center py-3 border-2 border-dashed border-[#6f4e37] text-[#6f4e37] rounded-xl font-bold text-sm hover:bg-stone-50">
                + Tambah Alamat Baru
            </a>
        </div>
    </div>
</div>
{{-- 2. PRODUK PESANAN --}}
<div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
    <div class="p-4 border-b bg-gray-50/50 text-gray-800 font-bold uppercase text-xs tracking-widest">
        Produk Dipesan
    </div>
    <div class="divide-y divide-gray-100">
        @forelse($cart_items as $item)
            {{-- Pastikan menggunakan $item->menu sesuai relasi di controller --}}
            @if($item->menu)
                <div class="p-4 flex gap-4 items-center">
                    {{-- Gambar Produk --}}
                    <div class="relative">
    {{-- Mengarah langsung ke public/images/menu/ --}}
    @if($item->menu && $item->menu->image)
        <img src="{{ asset('images/menu/' . $item->menu->image) }}" 
             class="w-20 h-20 object-cover rounded-xl border border-gray-100 shadow-sm" 
             alt="{{ $item->menu->name }}"
             onerror="this.onerror=null;this.src='{{ asset('images/default-coffee.jpg') }}';">
    @else
        <div class="w-20 h-20 bg-gray-200 rounded-xl flex items-center justify-center">
             <span class="text-[10px] text-gray-400">No Image</span>
        </div>
    @endif
    
    <span class="absolute -top-2 -right-2 bg-[#6f4e37] text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-sm">
        x{{ $item->quantity }}
    </span>
</div>
                    
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 text-lg line-clamp-1">{{ $item->menu->name }}</h4>
                        <p class="text-xs text-gray-400 capitalize">Kategori: {{ $item->menu->category ?? 'Minuman' }}</p>
                        
                        <div class="flex justify-between items-center mt-2">
                            <p class="text-[#6f4e37] font-black text-base">
                                Rp {{ number_format($item->menu->price, 0, ',', '.') }}
                            </p>
                            <p class="text-xs font-medium text-gray-400">
                                Subtotal: Rp {{ number_format($item->menu->price * $item->quantity, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            @else
                {{-- Ini akan muncul jika data di tabel menu_coffee tidak ditemukan --}}
                <div class="p-4 bg-red-50 flex items-center gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    <p class="text-red-500 text-xs italic font-medium">Data produk sudah tidak tersedia di menu.</p>
                </div>
            @endif
        @empty
            <div class="p-10 text-center">
                <p class="text-gray-400 text-sm">Keranjang belanja Anda kosong.</p>
            </div>
        @endforelse
    </div>
    
    <div class="p-4 bg-stone-50 border-t flex justify-between items-center text-sm">
        <span class="text-gray-500 italic">Opsi Pengiriman: <strong class="text-gray-700">Reguler (Kurir Toko)</strong></span>
        <span class="font-bold text-[#6f4e37] bg-white px-3 py-1 rounded-lg shadow-sm border border-stone-100">Otomatis</span>
    </div>
</div>


                {{-- 3. METODE PEMBAYARAN (COD) --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#6f4e37]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Metode Pembayaran
                    </h3>
                    <div class="flex items-center p-4 border-2 border-[#6f4e37] bg-stone-50 rounded-xl relative">
                        <div class="flex-1">
                            <p class="font-black text-[#6f4e37] text-base uppercase">COD (Bayar di Tempat)</p>
                            <p class="text-xs text-stone-500">Bayar pesanan saat kurir tiba di lokasi Anda.</p>
                        </div>
                        <div class="bg-[#6f4e37] text-white p-1 rounded-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Kolom Kanan: Rincian & Voucher --}}
            <div class="lg:col-span-1 space-y-4">
                {{-- VOUCHER --}}
                <div class="bg-white p-5 rounded-2xl shadow-sm border-l-4 border-orange-400">
                    <div class="flex items-center gap-2 mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        <span class="text-sm font-bold text-gray-700 uppercase italic">Voucher Kopi</span>
                    </div>
                    <div class="flex gap-2">
                        <input type="text" placeholder="Kode voucher" class="flex-1 text-xs border border-stone-200 rounded-xl p-3 outline-none bg-stone-50">
                        <button class="bg-[#6f4e37] text-white px-4 py-2 rounded-xl text-xs font-bold uppercase transition-all hover:bg-[#3c2a1e]">Pakai</button>
                    </div>
                </div>

                {{-- RINCIAN PEMBAYARAN --}}
                <div class="bg-white p-6 rounded-3xl shadow-xl border border-gray-50 sticky top-10">
                    <h3 class="font-bold text-[#6f4e37] mb-6 border-b pb-4 uppercase tracking-widest text-xs">Rincian Pembayaran</h3>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Subtotal Produk</span>
                            <span class="font-bold text-gray-800">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Ongkos Kirim</span>
                            <span id="display-ongkir" class="font-bold text-gray-800">Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm text-gray-500">
                            <span>Diskon Voucher</span>
                            <span class="text-green-600 font-bold">- Rp 0</span>
                        </div>
                        <hr class="border-dashed my-4">
                        <div class="flex justify-between font-black text-2xl text-[#6f4e37]">
                            <span>Total</span>
                            <span id="display-total">Rp {{ number_format($total_pembayaran, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf
                        <input type="hidden" name="alamat_id" id="final-alamat-id" value="{{ $selected_address->id ?? '' }}">
                        <input type="hidden" name="payment_method" value="COD">
                        <button type="submit" class="w-full bg-[#6f4e37] text-white py-5 rounded-2xl font-black shadow-xl hover:bg-[#3c2a1e] transition-all uppercase tracking-widest text-sm">
                            Buat Pesanan Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    /**
     * Membuka Modal Alamat
     */
    function openAddressModal() {
        const modal = document.getElementById('addressModal');
        if (modal) {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // Kunci scroll layar belakang
        } else {
            console.error("Elemen 'addressModal' tidak ditemukan!");
        }
    }

    /**
     * Menutup Modal Alamat
     */
    function closeAddressModal() {
        const modal = document.getElementById('addressModal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Aktifkan kembali scroll
        }
    }

    /**
     * Memilih Alamat & Update Biaya Secara Real-time
     * Fungsi ini dipanggil saat salah satu kartu alamat di dalam modal diklik
     */
    function selectAddress(address) {
        // 1. Update Tampilan Alamat di Halaman Utama Checkout
        const display = document.getElementById('active-address-display');
        if (display) {
            display.innerHTML = `
                <p class="font-bold text-gray-800 text-base mb-1">${address.nama_penerima} | ${address.no_telepon}</p>
                <p class="leading-relaxed text-gray-600">${address.alamat_lengkap}, ${address.kota}, ${address.provinsi}</p>
                <input type="hidden" name="alamat_id" id="selected-address-id" value="${address.id}">
            `;
        }

        // 2. Masukkan ID Alamat ke dalam Form Hidden agar terkirim ke Controller saat submit
        const finalInput = document.getElementById('final-alamat-id');
        if (finalInput) {
            finalInput.value = address.id;
        }

        // 3. Logika Perhitungan Ongkir Berdasarkan Jarak
        const tarifPerKm = 2000;
        const jarak = parseFloat(address.jarak) || 0;
        let jarakHitung = jarak > 7 ? 7 : jarak; // Maksimal jarak yang dihitung ongkirnya adalah 7km
        const ongkirBaru = Math.round(jarakHitung * tarifPerKm);
        
        // Mengambil subtotal dari variabel PHP (Blade)
        const subtotal = {{ $subtotal ?? 0 }};
        const totalBaru = subtotal + ongkirBaru;

        // 4. Update Tampilan Angka di Rincian Pembayaran (Format Rupiah)
        const displayOngkir = document.getElementById('display-ongkir');
        const displayTotal = document.getElementById('display-total');

        if (displayOngkir) {
            displayOngkir.innerText = `Rp ${ongkirBaru.toLocaleString('id-ID')}`;
        }
        if (displayTotal) {
            displayTotal.innerText = `Rp ${totalBaru.toLocaleString('id-ID')}`;
        }

        // 5. Tutup Modal
        closeAddressModal();

        // 6. Feedback Visual (Opsional menggunakan SweetAlert)
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'success',
                title: 'Alamat Berhasil Dipilih',
                text: 'Ongkos kirim telah diperbarui otomatis.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        }
    }

    /**
     * Menutup modal jika pengguna mengklik area luar modal (overlay hitam)
     */
    window.onclick = function(event) {
        const modal = document.getElementById('addressModal');
        if (event.target == modal) {
            closeAddressModal();
        }
    }
</script>
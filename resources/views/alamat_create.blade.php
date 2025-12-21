@extends('landing-page.landing-page')

@section('content')
<div class="max-w-5xl mx-auto px-4 py-8">
    {{-- Main Card --}}
    <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-stone-200 border border-stone-100 overflow-hidden">
        
        {{-- Header Section --}}
        <div class="p-8 border-b border-stone-50 bg-gradient-to-r from-[#faf7f2] to-[#ffffff] flex items-center justify-between">
            <div class="flex items-center gap-5">
                <a href="{{ route('profil') }}" class="group flex items-center justify-center w-12 h-12 rounded-2xl bg-white border border-stone-200 text-stone-400 hover:text-[#6f4e37] hover:border-[#6f4e37] hover:shadow-md transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <br><br><br>
                    <h1 class="text-2xl font-black text-[#3c2a1e] tracking-tight">Detail Lokasi Baru</h1>
                    <p class="text-stone-400 text-sm font-medium">Lengkapi alamat pengiriman kopi favoritmu</p>
                </div>
            </div>
            <div class="hidden md:block">
                <span class="px-4 py-2 bg-[#6f4e37]/10 text-[#6f4e37] text-xs font-bold rounded-full uppercase tracking-widest">Priority Delivery</span>
            </div>
        </div>

        <form id="formTambahAlamat" class="p-8 md:p-12">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                {{-- Sisi Kiri: Form Fields (Column 5) --}}
                <div class="lg:col-span-5 space-y-7">
                    <div class="space-y-6">
                        <h3 class="text-lg font-bold text-[#3c2a1e] flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-[#6f4e37] text-white flex items-center justify-center text-sm">1</span>
                            Informasi Penerima
                        </h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-[#6f4e37] uppercase tracking-wider ml-1">Nama Penerima</label>
                                <input type="text" name="penerima" class="w-full border-stone-200 rounded-2xl p-4 bg-stone-50/50 focus:ring-4 focus:ring-[#6f4e37]/5 focus:border-[#6f4e37] focus:bg-white transition-all text-sm placeholder:text-stone-300" placeholder="Contoh: Andi Wijaya" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[11px] font-black text-[#6f4e37] uppercase tracking-wider ml-1">Nomor Telepon</label>
                                <input type="text" name="telepon" class="w-full border-stone-200 rounded-2xl p-4 bg-stone-50/50 focus:ring-4 focus:ring-[#6f4e37]/5 focus:border-[#6f4e37] focus:bg-white transition-all text-sm placeholder:text-stone-300" placeholder="0812xxxx" required>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-[#6f4e37] uppercase tracking-wider ml-1">Label Alamat</label>
                            <input type="text" name="label" class="w-full border-stone-200 rounded-2xl p-4 bg-stone-50/50 focus:ring-4 focus:ring-[#6f4e37]/5 focus:border-[#6f4e37] focus:bg-white transition-all text-sm placeholder:text-stone-300" placeholder="Contoh: Rumah, Kantor, Apartemen" required>
                        </div>
                    </div>

                    <div class="space-y-6 pt-4">
                        <h3 class="text-lg font-bold text-[#3c2a1e] flex items-center gap-2">
                            <span class="w-8 h-8 rounded-lg bg-[#6f4e37] text-white flex items-center justify-center text-sm">2</span>
                            Detail Alamat
                        </h3>
                        
                        <div class="space-y-2">
                            <label class="text-[11px] font-black text-[#6f4e37] uppercase tracking-wider ml-1">Alamat Lengkap & Patokan</label>
                            <textarea name="alamat" id="alamatLengkap" rows="4" class="w-full border-stone-200 rounded-2xl p-4 bg-stone-50/50 focus:ring-4 focus:ring-[#6f4e37]/5 focus:border-[#6f4e37] focus:bg-white transition-all text-sm placeholder:text-stone-300 resize-none" placeholder="Tuliskan nama jalan, blok, nomor rumah, dan patokan (misal: cat pagar merah)" required></textarea>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <input type="text" name="kota" id="kota" placeholder="Kota" class="w-full border-stone-200 rounded-xl p-3 bg-stone-100 text-[11px] font-bold text-stone-500 uppercase tracking-tighter cursor-not-allowed" readonly>
                            <input type="text" name="provinsi" id="provinsi" placeholder="Provinsi" class="w-full border-stone-200 rounded-xl p-3 bg-stone-100 text-[11px] font-bold text-stone-500 uppercase tracking-tighter cursor-not-allowed" readonly>
                            <input type="text" name="kode_pos" id="kode_pos" placeholder="Pos" class="w-full border-stone-200 rounded-xl p-3 bg-stone-100 text-[11px] font-bold text-stone-500 uppercase tracking-tighter cursor-not-allowed" readonly>
                        </div>
                    </div>

                    <input type="hidden" name="latitude" id="lat">
                    <input type="hidden" name="longitude" id="lng">
                    <input type="hidden" name="jarak" id="jarak_input">
                </div>

                {{-- Sisi Kanan: Map Section (Column 7) --}}
              <div class="lg:col-span-7 flex flex-col space-y-6">
    <h3 class="text-lg font-bold text-[#3c2a1e] flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="w-8 h-8 rounded-lg bg-[#6f4e37] text-white flex items-center justify-center text-sm font-bold">3</span>
            Titik Presisi
        </div>
        <span id="distance-badge" class="text-[10px] bg-orange-100 text-orange-700 px-3 py-1 rounded-full font-black uppercase italic">Jarak: -- KM</span>
    </h3>

    <div class="relative w-full rounded-[1.8rem] border-4 border-white shadow-xl overflow-hidden group" style="min-height: 400px;">
        <div id="mapAlamatProfil" class="absolute inset-0 w-full h-full z-10"></div>
        
        <button type="button" id="btnLokasiSaya" class="absolute top-4 right-4 z-[1000] bg-white/90 backdrop-blur-sm text-[#6f4e37] px-4 py-2 rounded-xl shadow-lg hover:bg-[#6f4e37] hover:text-white transition-all duration-300 font-bold text-xs flex items-center gap-2 border border-stone-100">
            <span class="relative flex h-2 w-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#6f4e37] opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-[#6f4e37]"></span>
            </span>
            DETEKSI LOKASI SAYA
        </button>
    </div>

    <div class="flex flex-col sm:flex-row gap-4 pt-4">
        <a href="{{ route('profil') }}" class="flex-1 text-center py-4 border-2 border-stone-100 rounded-2xl font-bold text-stone-400 hover:bg-stone-50 hover:text-stone-600 transition-all duration-300 uppercase tracking-widest text-xs">
            Batalkan
        </a>
        <button type="submit" class="flex-[2] py-4 bg-[#6f4e37] text-white rounded-2xl font-black shadow-xl shadow-[#6f4e37]/30 hover:bg-[#3c2a1e] hover:-translate-y-1 transition-all duration-300 uppercase tracking-[0.2em] text-xs">
            Simpan & Konfirmasi
        </button>
    </div>
</div>

    {{-- Footer Info --}}
    <p class="mt-8 text-center text-stone-400 text-xs font-medium uppercase tracking-[0.3em]">
        Handcrafted with passion • Bean & Brew Coffee Co.
    </p>
</div>

<style>
    /* Custom Map Style to match Coffee Theme */
    .leaflet-container {
        background: #fdfaf7 !important;
        font-family: 'Inter', sans-serif;
    }
    .leaflet-bar {
        border: none !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05) !important;
    }
    .leaflet-bar a {
        background-color: white !important;
        color: #6f4e37 !important;
        border-bottom: 1px solid #f0f0f0 !important;
    }
    /* Rounded corners for map zoom controls */
    .leaflet-control-zoom {
        border-radius: 12px !important;
        overflow: hidden;
    }
</style>
@endsection
@push('scripts')
<script>
let map, marker;
const tokoLat = {{ $resto->latitude ?? -6.7567 }};
const tokoLng = {{ $resto->longitude ?? 107.0090 }};
const tokoLatLng = L.latLng(tokoLat, tokoLng);

document.addEventListener('DOMContentLoaded', () => {
    initMap();
    setupForm();
});
function initMap() {
    // Koordinat default (Toko/Pusat)
    const defaultPos = [tokoLat, tokoLng];
    
    // Inisialisasi Map
    map = L.map('mapAlamatProfil').setView(defaultPos, 13);
    
    // MENGAKTIFKAN GOOGLE MAPS LAYER (Roadmap)
    L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains:['mt0','mt1','mt2','mt3'],
        attribution: '© Google Maps'
    }).addTo(map);

    // Pin Penanda yang bisa digeser (Custom Style Coffee)
    const coffeeIcon = L.divIcon({
        html: `<div class="bg-[#6f4e37] w-8 h-8 rounded-full border-4 border-white shadow-lg flex items-center justify-center text-white animate-bounce">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                </svg>
               </div>`,
        className: '',
        iconSize: [32, 32],
        iconAnchor: [16, 32]
    });

    marker = L.marker(defaultPos, { 
        draggable: true,
        icon: coffeeIcon 
    }).addTo(map);

    // Event saat peta diklik
    map.on('click', e => updateMarker(e.latlng.lat, e.latlng.lng));
    
    // Event saat pin digeser
    marker.on('dragend', e => updateMarker(e.target.getLatLng().lat, e.target.getLatLng().lng));
    // Update Badge Jarak di UI
const badge = document.getElementById('distance-badge');
if(badge) {
    badge.innerText = `Jarak: ${distanceKm} KM`;
    // Beri warna merah jika terlalu jauh (misal > 10km)
    if(distanceKm > 10) {
        badge.classList.replace('bg-orange-100', 'bg-red-100');
        badge.classList.replace('text-orange-700', 'text-red-700');
    } else {
        badge.classList.replace('bg-red-100', 'bg-orange-100');
        badge.classList.replace('text-red-700', 'text-orange-700');
    }
}
}

async function fetchAddress(lat, lng) {
    try {
        const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
        const data = await res.json();
        const addr = data.address || {};
        
        document.getElementById('alamatLengkap').value = data.display_name || '';
        document.getElementById('kota').value = addr.city || addr.town || addr.village || '';
        document.getElementById('provinsi').value = addr.state || '';
        document.getElementById('kode_pos').value = addr.postcode || '';
    } catch (e) { console.error("Gagal ambil alamat"); }
}

function setupForm() {
    const form = document.getElementById('formTambahAlamat');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        Swal.fire({ title: 'Menyimpan...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        try {
            const res = await fetch("{{ route('profil.alamat.store') }}", {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: new FormData(form)
            });
            const data = await res.json();

            if (data.success) {
                Swal.fire('Berhasil', data.success, 'success').then(() => window.location.href = "{{ route('profil') }}");
            } else {
                Swal.fire('Gagal', data.error || 'Cek kembali data anda', 'error');
            }
        } catch (err) {
            Swal.fire('Error', 'Gagal menghubungi server', 'error');
        }
    });

    document.getElementById('btnLokasiSaya').addEventListener('click', () => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(pos => {
                updateMarker(pos.coords.latitude, pos.coords.longitude, 17);
            });
        }
    });
}
</script>
@endpush

<script>
let map, marker;

// Data Koordinat Default
const tokoLat = {{ $resto->latitude ?? -6.7567 }};
const tokoLng = {{ $resto->longitude ?? 107.0090 }};

function initMap() {
    // Pastikan elemen ada sebelum inisialisasi
    const mapContainer = document.getElementById('mapAlamatProfil');
    if (!mapContainer) return;

    // Inisialisasi Leaflet
    map = L.map('mapAlamatProfil', {
        zoomControl: true,
        scrollWheelZoom: true
    }).setView([tokoLat, tokoLng], 13);

    // Tile Layer Google Maps (Roadmap)
    L.tileLayer('https://mt1.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        attribution: '© Google Maps'
    }).addTo(map);

    // Tambahkan Marker Default
    marker = L.marker([tokoLat, tokoLng], {
        draggable: true
    }).addTo(map);

    // MAKSIMALKAN RENDER (Solusi Peta Blank)
    setTimeout(() => {
        map.invalidateSize();
    }, 400);

    // Event Klik & Drag
    map.on('click', e => updatePos(e.latlng.lat, e.latlng.lng));
    marker.on('dragend', e => updatePos(e.target.getLatLng().lat, e.target.getLatLng().lng));
}

function updatePos(lat, lng) {
    marker.setLatLng([lat, lng]);
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;
    
    // Hitung jarak (formula sederhana atau Leaflet distanceTo)
    const storeLatLng = L.latLng(tokoLat, tokoLng);
    const userLatLng = L.latLng(lat, lng);
    const dist = (storeLatLng.distanceTo(userLatLng) / 1000).toFixed(1);
    
    document.getElementById('jarak_input').value = dist;
    document.getElementById('distance-badge').innerText = `Jarak: ${dist} KM`;

    // Ambil detail alamat (Reverse Geocoding)
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(r => r.json())
        .then(data => {
            document.getElementById('alamatLengkap').value = data.display_name || '';
            const a = data.address || {};
            document.getElementById('kota').value = a.city || a.town || a.village || '';
            document.getElementById('provinsi').value = a.state || '';
            document.getElementById('kode_pos').value = a.postcode || '';
        });
}

// Jalankan saat window selesai load
window.addEventListener('load', initMap);
</script>
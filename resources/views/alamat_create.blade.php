@extends('landing-page.landing-page')

@section('content')

<br><br><br>
<div class="max-w-6xl mx-auto px-4 py-6 md:py-12">
    {{-- Main Card --}}
    <div class="bg-white rounded-[2rem] md:rounded-[3rem] shadow-2xl shadow-stone-200 border border-stone-100 overflow-hidden">
        
        {{-- Header Section --}}
        <div class="p-6 md:p-10 border-b border-stone-50 bg-gradient-to-r from-[#faf7f2] to-[#ffffff] flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4 md:gap-6">
                <a href="{{ route('profil') }}" class="group flex items-center justify-center w-10 h-10 md:w-12 md:h-12 rounded-xl md:rounded-2xl bg-white border border-stone-200 text-stone-400 hover:text-[#6f4e37] hover:border-[#6f4e37] hover:shadow-md transition-all duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </a>
                <div>
                    <h1 class="text-xl md:text-2xl font-black text-[#3c2a1e] tracking-tight leading-tight">Detail Lokasi Baru</h1>
                    <p class="text-stone-400 text-xs md:text-sm font-medium">Lengkapi alamat pengiriman kopi favoritmu</p>
                </div>
            </div>
            <div class="self-start md:self-center">
                <span class="px-3 py-1.5 md:px-4 md:py-2 bg-[#6f4e37]/10 text-[#6f4e37] text-[10px] md:text-xs font-bold rounded-full uppercase tracking-widest">Priority Delivery</span>
            </div>
        </div>

        <form action="{{ route('profil.alamat.store') }}" method="POST" id="formTambahAlamat" class="p-6 md:p-10 lg:p-14">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 md:gap-14">
                
                {{-- Sisi Kiri: Form Fields --}}
                <div class="lg:col-span-5 space-y-8">
                    {{-- Section 1 --}}
                    <div class="space-y-6">
                        <h3 class="text-base md:text-lg font-bold text-[#3c2a1e] flex items-center gap-3">
                            <span class="w-7 h-7 md:w-8 md:h-8 rounded-lg bg-[#6f4e37] text-white flex items-center justify-center text-xs md:text-sm shadow-lg shadow-[#6f4e37]/20">1</span>
                            Informasi Penerima
                        </h3>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-[10px] md:text-[11px] font-black text-[#6f4e37] uppercase tracking-wider ml-1">Nama Penerima</label>
                                <input type="text" name="penerima" class="w-full border-stone-200 rounded-xl md:rounded-2xl p-3 md:p-4 bg-stone-50/50 focus:ring-4 focus:ring-[#6f4e37]/5 focus:border-[#6f4e37] focus:bg-white transition-all text-sm" placeholder="Andi Wijaya" required>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] md:text-[11px] font-black text-[#6f4e37] uppercase tracking-wider ml-1">Nomor Telepon</label>
                                <input type="text" name="telepon" class="w-full border-stone-200 rounded-xl md:rounded-2xl p-3 md:p-4 bg-stone-50/50 focus:ring-4 focus:ring-[#6f4e37]/5 focus:border-[#6f4e37] focus:bg-white transition-all text-sm" placeholder="0812xxxx" required>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] md:text-[11px] font-black text-[#6f4e37] uppercase tracking-wider ml-1">Label Alamat</label>
                            <input type="text" name="label" class="w-full border-stone-200 rounded-xl md:rounded-2xl p-3 md:p-4 bg-stone-50/50 focus:ring-4 focus:ring-[#6f4e37]/5 focus:border-[#6f4e37] focus:bg-white transition-all text-sm" placeholder="Rumah, Kantor, dll" required>
                        </div>
                    </div>

                    {{-- Section 2 --}}
                    <div class="space-y-6">
                        <h3 class="text-base md:text-lg font-bold text-[#3c2a1e] flex items-center gap-3">
                            <span class="w-7 h-7 md:w-8 md:h-8 rounded-lg bg-[#6f4e37] text-white flex items-center justify-center text-xs md:text-sm shadow-lg shadow-[#6f4e37]/20">2</span>
                            Detail Alamat
                        </h3>
                        
                        <div class="space-y-2">
                            <label class="text-[10px] md:text-[11px] font-black text-[#6f4e37] uppercase tracking-wider ml-1">Alamat Lengkap & Patokan</label>
                            <textarea name="alamat" id="alamatLengkap" rows="4" class="w-full border-stone-200 rounded-xl md:rounded-2xl p-3 md:p-4 bg-stone-50/50 focus:ring-4 focus:ring-[#6f4e37]/5 focus:border-[#6f4e37] focus:bg-white transition-all text-sm resize-none" placeholder="Nama jalan, blok, No rumah, patokan..." required></textarea>
                        </div>

                       
                    </div>

                    <input type="hidden" name="latitude" id="lat">
                    <input type="hidden" name="longitude" id="lng">
                    <input type="hidden" name="jarak" id="jarak_input">
                </div>

                {{-- Sisi Kanan: Map Section --}}
                <div class="lg:col-span-7 flex flex-col space-y-6">
                    <h3 class="text-base md:text-lg font-bold text-[#3c2a1e] flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <span class="w-7 h-7 md:w-8 md:h-8 rounded-lg bg-[#6f4e37] text-white flex items-center justify-center text-xs md:text-sm font-bold shadow-lg shadow-[#6f4e37]/20">3</span>
                            Titik Presisi Google Maps
                        </div>
                        <span id="distance-badge" class="text-[10px] bg-[#6f4e37] text-white px-3 py-1 rounded-full font-black uppercase italic shadow-sm">Jarak: -- KM</span>
                    </h3>


                    <div class="relative w-full rounded-[1.5rem] md:rounded-[2.5rem] border-4 border-white shadow-2xl overflow-hidden bg-stone-100 h-[350px] md:h-[450px] lg:h-full min-h-[350px]">
                        {{-- Kontainer Map --}}
                        <div class="absolute top-20 right-4 z-[500] flex flex-col gap-2">
    <button type="button" id="toggleTheme" class="bg-white/90 dark:bg-stone-800 p-3 rounded-xl shadow-lg border border-stone-100 dark:border-stone-700 transition-all">
        <svg id="sunIcon" class="w-5 h-5 text-orange-500 hidden" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"/></svg>
        <svg id="moonIcon" class="w-5 h-5 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"><path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"/></svg>
    </button>
</div>

<button id="btnLokasiSaya" type="button">
    <svg class="w-4 h-4" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
    </svg>
    <span>LOKASI SAYA</span>
</button>
                        <div id="googleMap" class="w-full h-full"></div>
                        
                        {{-- Tombol Lokasi Saya --}}
    <button id="btnLokasiSaya" type="button" class="flex items-center">
    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
    </svg>
    <span>LOKASI SAYA</span>
</button>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex flex-col sm:flex-row gap-3 md:gap-4 pt-4">
                        <a href="{{ route('profil') }}" class="order-2 sm:order-1 flex-1 text-center py-4 border-2 border-stone-100 rounded-xl md:rounded-2xl font-bold text-stone-400 hover:bg-stone-50 hover:text-stone-600 transition-all duration-300 uppercase tracking-widest text-[10px] md:text-xs">
                            Batalkan
                        </a>
                        <button type="submit" class="order-1 sm:order-2 flex-[2] py-4 bg-[#6f4e37] text-white rounded-xl md:rounded-2xl font-black shadow-xl shadow-[#6f4e37]/30 hover:bg-[#3c2a1e] hover:-translate-y-1 transition-all duration-300 uppercase tracking-[0.2em] text-[10px] md:text-xs">
                            Simpan & Konfirmasi
                        </button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Footer Info --}}
        <div class="bg-stone-50 py-6 border-t border-stone-100">
            <p class="text-center text-stone-400 text-[10px] font-medium uppercase tracking-[0.3em]">
                Handcrafted with passion • Bean & Brew Coffee Co.
            </p>
        </div>
    </div>
</div>
@endsection


<style>
 /* KANAN ATAS – MENTOK & RAPI */
.leaflet-top.leaflet-right {
    top: 12px !important;
    right: 12px !important;
    display: flex !important;
    flex-direction: column !important;
    align-items: flex-end !important;
    gap: 10px !important;
}

/* Reset margin default Leaflet */
.leaflet-top.leaflet-right .leaflet-control {
    margin: 0 !important;
    clear: none !important;
}


    /* 2. Styling Tombol Pencarian Bundar Cokelat (Gambar 2 & 6) */
    .leaflet-control-geocoder-icon {
        background-color: #6f4e37 !important;
        border-radius: 50% !important;
        width: 42px !important;
        height: 42px !important;
        border: 2px solid #ffffff !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2) !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='white'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z'/%3E%3C/svg%3E") !important;
        background-size: 22px !important;
        background-position: center !important;
    }

    /* 3. Kolom Input Pencarian (Gambar 3 & 6) */
    .leaflet-control-geocoder-form {
        position: absolute;
        right: 50px; /* Muncul di kiri tombol bundar */
        top: 2px;
        background: white !important;
        border: 2px solid #6f4e37 !important;
        border-radius: 20px !important;
        padding: 5px 15px !important;
        width: 240px !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15) !important;
    }

    /* 4. Tombol Lokasi Saya (Kanan Bawah - Gambar 1, 2, 4) */
    .leaflet-bottom.leaflet-right {
        margin-bottom: 25px !important;
        margin-right: 12px !important;
    }

    #btnLokasiSaya {
        background-color: #6f4e37 !important;
        color: white !important; /* Diubah ke putih agar lebih profesional */
        padding: 10px 16px !important;
        border-radius: 8px !important;
        font-weight: 800 !important;
        font-size: 11px !important;
        border: 2px solid #ffffff !important;
        box-shadow: 0 4px 12px rgba(0,0,0,0.25) !important;
        display: flex;
        align-items: center;
        gap: 8px;
        text-transform: uppercase;
    }

    /* Style Icon Pin di dalam Tombol Lokasi */
    #btnLokasiSaya svg {
        width: 16px;
        height: 16px;
        fill: white !important;
    }
</style>













@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
let map, marker, baseLayers;

// Koordinat Resto (Pusat)
const restoLat = {{ $resto->latitude ?? -6.77005553 }};
const restoLng = {{ $resto->longitude ?? 107.04799231 }};

/**
 * Fungsi Simpan dengan SweetAlert2 Tema Coffee
 */
function setupFormSubmit() {
    const form = document.getElementById('formTambahAlamat');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Menyimpan...',
            text: 'Sedang memproses alamat Anda',
            allowOutsideClick: false,
            color: '#4b3832', 
            didOpen: () => { 
                Swal.showLoading();
                const loader = document.querySelector('.swal2-loader');
                if(loader) loader.style.borderColor = '#6f4e37 transparent #6f4e37 transparent';
            }
        });

        const formData = new FormData(this);

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    iconColor: '#6f4e37',
                    title: '<span style="color: #4b3832">Berhasil!</span>',
                    text: 'Alamat Anda telah berhasil disimpan.',
                    color: '#4b3832',
                    background: '#fffaf5',
                    showConfirmButton: true,
                    confirmButtonText: 'MANTAP!',
                    confirmButtonColor: '#6f4e37',
                }).then(() => {
                    if (data.redirect) {
                        window.location.href = data.redirect;
                    } else {
                        form.reset(); 
                        updatePosition(restoLat, restoLng);
                        map.flyTo([restoLat, restoLng], 15);
                    }
                });
            } else {
                Swal.fire({ 
                    icon: 'error', 
                    title: 'Gagal', 
                    text: data.error || 'Terjadi kesalahan.',
                    confirmButtonColor: '#6f4e37'
                });
            }
        })
        .catch((err) => {
            console.error(err);
            Swal.fire({ 
                icon: 'error', 
                title: 'Error', 
                text: 'Gagal terhubung ke server.',
                confirmButtonColor: '#6f4e37' 
            });
        });
    });
}


function initLeafletMap() {
    const mapElement = document.getElementById("googleMap");
    if (!mapElement) return;

    const googleRoadmap = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'], attribution: 'Google Maps'
    });
    const googleSatellite = L.tileLayer('https://{s}.google.com/vt/lyrs=s,h&x={x}&y={y}&z={z}', {
        maxZoom: 20, subdomains: ['mt0', 'mt1', 'mt2', 'mt3'], attribution: 'Google Satellite'
    });

    map = L.map(mapElement, {
        center: [restoLat, restoLng],
        zoom: 15,
        layers: [googleRoadmap]
    });

    // 1. Kontrol Layer Satelit (Kanan Atas)
    L.control.layers({
        "Google Maps": googleRoadmap,
        "Satelit": googleSatellite
    }, null, { position: 'topright' }).addTo(map);

    // 2. Kontrol Mode Gelap (Kanan Atas - Muncul di bawah Satelit)
    setupThemeToggle();

    // 3. Kolom Pencarian / Geocoder (Kanan Atas - Muncul di bawah Mode Gelap)
    if (typeof L.Control.Geocoder !== 'undefined') {
        const geocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            placeholder: "Cari lokasi...",
            position: 'topright', // Di bawah Mode Gelap
            collapsed: true       // Aktifkan mode Klik-Muncul-Klik-Hilang
        })
        .on('markgeocode', function(e) {
            const latlng = e.geocode.center;
            updatePosition(latlng.lat, latlng.lng);
            map.flyTo(latlng, 17);
            
            // Otomatis tutup kolom setelah cari (Opsional)
            geocoder._collapse(); 
        })
        .addTo(map);
    }

    // 4. Kontrol Lokasi Saya (Kanan Bawah)
    setupGeolocation();

    // Marker Custom & Event Handling (Tetap sama)
    const customIcon = L.divIcon({
        html: `<div class="bg-[#6f4e37] w-10 h-10 rounded-full border-4 border-white shadow-2xl flex items-center justify-center text-white"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg></div>`,
        className: '', iconSize: [40, 40], iconAnchor: [20, 40]
    });
    marker = L.marker([restoLat, restoLng], { draggable: true, icon: customIcon }).addTo(map);

    map.on('click', (e) => updatePosition(e.latlng.lat, e.latlng.lng));
    marker.on('dragend', (e) => updatePosition(e.target.getLatLng().lat, e.target.getLatLng().lng));

    setupFormSubmit(); 
}
function setupThemeToggle() {
    const btn = document.getElementById('toggleTheme');
    if (!btn) return;

    const ThemeControl = L.Control.extend({
        options: { position: 'topright' }, // Di bawah tombol satelit
        onAdd: function() {
            const div = L.DomUtil.create('div', 'mt-2'); // mt-2 memberi jarak visual
            div.appendChild(btn);
            return div;
        }
    });
    map.addControl(new ThemeControl());

    btn.addEventListener('click', () => {
        const isDark = document.documentElement.classList.toggle('dark');
        document.getElementById('moonIcon').classList.toggle('hidden');
        document.getElementById('sunIcon').classList.toggle('hidden');
        document.getElementById('googleMap').style.filter = isDark ? 
            'invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%)' : 'none';
    });
}

function setupGeolocation() {
    const btn = document.getElementById('btnLokasiSaya');
    if (!btn) return;

    // Masukkan tombol ke sistem kontrol Leaflet di Kanan Bawah
    const LocationControl = L.Control.extend({
        options: { position: 'bottomright' },
        onAdd: function() {
            const container = L.DomUtil.create('div', 'custom-location-wrapper');
            container.appendChild(btn);
            return container;
        }
    });
    map.addControl(new LocationControl());

    btn.addEventListener('click', () => {
        if (!navigator.geolocation) return alert('GPS tidak didukung');
        
        const originalContent = btn.innerHTML;
        btn.innerHTML = 'Mencari...';

        navigator.geolocation.getCurrentPosition((pos) => {
            updatePosition(pos.coords.latitude, pos.coords.longitude);
            map.flyTo([pos.coords.latitude, pos.coords.longitude], 17);
            btn.innerHTML = originalContent;
        }, () => {
            alert('Gagal mendeteksi lokasi');
            btn.innerHTML = originalContent;
        });
    });
}

function setupGeolocation() {
    const btn = document.getElementById('btnLokasiSaya');
    if (!btn) return;

    // Membuat Kontrol Leaflet Kustom
    const LocationControl = L.Control.extend({
        options: { 
            position: 'bottomright' // Menentukan posisi di kanan bawah
        },
        onAdd: function() {
            // Kita bungkus tombol di dalam div agar margin dan tata letaknya konsisten
            const container = L.DomUtil.create('div', 'leaflet-custom-control');
            container.appendChild(btn);
            return container;
        }
    });

    // Masukkan ke dalam map
    map.addControl(new LocationControl());

    // Logika deteksi lokasi tetap sama
    btn.addEventListener('click', () => {
        if (!navigator.geolocation) return alert('GPS tidak didukung');
        
        const originalText = btn.innerHTML;
        btn.innerHTML = 'Mencari...';

        navigator.geolocation.getCurrentPosition((pos) => {
            updatePosition(pos.coords.latitude, pos.coords.longitude);
            map.flyTo([pos.coords.latitude, pos.coords.longitude], 17);
            btn.innerHTML = originalText;
        }, () => {
            alert('Gagal mendeteksi lokasi');
            btn.innerHTML = originalText;
        });
    });
}

function updatePosition(lat, lng) {
    marker.setLatLng([lat, lng]);
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;

    const distanceKm = hitungJarak(restoLat, restoLng, lat, lng).toFixed(1);
    const jarakInput = document.getElementById('jarak_input');
    const distanceBadge = document.getElementById('distance-badge');
    
    if(jarakInput) jarakInput.value = distanceKm;
    if(distanceBadge) distanceBadge.innerText = `Jarak: ${distanceKm} KM`;

    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
        .then(res => res.json())
        .then(data => {
            const alamatInput = document.getElementById('alamatLengkap');
            if (data && data.display_name && alamatInput) {
                alamatInput.value = data.display_name;
            }
        });
}

function hitungJarak(lat1, lon1, lat2, lon2) {
    const R = 6371;
    const dLat = (lat2 - lat1) * Math.PI / 180;
    const dLon = (lon2 - lon1) * Math.PI / 180;
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) * Math.sin(dLon / 2) * Math.sin(dLon / 2);
    return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
}

document.addEventListener('DOMContentLoaded', initLeafletMap);
</script>

@endpush
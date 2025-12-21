@extends('admin.layouts-admin.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">Pengaturan Lokasi Pusat Resto</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        {{-- BAGIAN PENCARIAN --}}
        <div class="mb-4">
            <label class="block mb-2 font-medium">Cari Lokasi (Nama Cafe, Kota, atau Alamat)</label>
            <div class="flex gap-2">
                <input type="text" id="search-input" 
                    class="w-full border border-[#d6c4b1] rounded-lg p-3 bg-[#fffdfb] focus:ring-2 focus:ring-[#c8a77a] shadow-sm transition" 
                    placeholder="Contoh: Sarongge Coffee, Cianjur...">
                <button type="button" id="search-button" 
                    class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 font-bold transition">
                    Cari Lokasi
                </button>
            </div>
            <p class="text-xs text-gray-500 mt-1">*Tekan Cari untuk memindahkan marker secara otomatis.</p>
        </div>

        {{-- BAGIAN PETA (HANYA SATU DIV DISINI) --}}
        <div id="map-admin" style="height: 450px;" class="mb-4 rounded-lg border shadow-inner"></div>

        {{-- FORM DATA --}}
        <form id="formResto">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Latitude</label>
                    <input type="text" name="latitude" id="lat" value="{{ $resto->latitude ?? '' }}" 
                        class="w-full p-2 border rounded bg-gray-50 text-gray-600 cursor-not-allowed" readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Longitude</label>
                    <input type="text" name="longitude" id="lng" value="{{ $resto->longitude ?? '' }}" 
                        class="w-full p-2 border rounded bg-gray-50 text-gray-600 cursor-not-allowed" readonly>
                </div>
            </div>
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Alamat Lengkap Resto (Hasil Deteksi Peta)</label>
                <textarea name="alamat_lengkap" id="alamat" class="w-full p-2 border rounded focus:ring-2 focus:ring-blue-500" 
                    rows="3" placeholder="Alamat akan terisi otomatis saat marker digeser...">{{ $resto->alamat_lengkap ?? '' }}</textarea>
            </div>
            
            <button type="submit" class="w-full bg-blue-600 text-white px-6 py-3 rounded-lg font-bold hover:bg-blue-700 transition">
                Simpan Lokasi Resto
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Koordinat awal
        let initialLat = {{ $resto->latitude ?? -6.736 }};
        let initialLng = {{ $resto->longitude ?? 107.068 }};

        // 2. Layer Google Maps (Roadmap & Hybrid)
        const googleRoadmap = L.tileLayer('https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
            maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3'], attribution: 'Google Maps'
        });
        const googleHybrid = L.tileLayer('https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
            maxZoom: 20, subdomains:['mt0','mt1','mt2','mt3'], attribution: 'Google Hybrid'
        });

        // 3. Inisialisasi Peta ke ID 'map-admin'
        const map = L.map('map-admin', {
            doubleClickZoom: false,
            layers: [googleRoadmap] // Tampilan standar Google Maps
        }).setView([initialLat, initialLng], 15);

        L.control.layers({ "Peta Jalan": googleRoadmap, "Satelit Hybrid": googleHybrid }).addTo(map);

        // 4. Marker
        const marker = L.marker([initialLat, initialLng], { draggable: true }).addTo(map);

        // Fungsi Update Form
        function updateLocation(lat, lng) {
            document.getElementById('lat').value = lat;
            document.getElementById('lng').value = lng;
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(res => res.json())
                .then(data => {
                    if(data.display_name) document.getElementById('alamat').value = data.display_name;
                });
        }

        // Fitur Cari
        document.getElementById('search-button').addEventListener('click', function() {
            const query = document.getElementById('search-input').value;
            if (query.length < 3) return;

            this.innerHTML = '⏳ Mencari...';
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(query)}&limit=1`)
                .then(res => res.json())
                .then(data => {
                    if (data.length > 0) {
                        const lat = parseFloat(data[0].lat);
                        const lon = parseFloat(data[0].lon);
                        marker.setLatLng([lat, lon]);
                        map.setView([lat, lon], 18);
                        updateLocation(lat, lon);
                    }
                })
                .finally(() => { this.innerHTML = 'Cari Lokasi'; });
        });

        // Event Klik & Geser
        map.on('dblclick', (e) => {
            marker.setLatLng(e.latlng);
            updateLocation(e.latlng.lat, e.latlng.lng);
        });
        marker.on('dragend', () => {
            const pos = marker.getLatLng();
            updateLocation(pos.lat, pos.lng);
        });
    });

    // --- FITUR SIMPAN DATA KE DATABASE ---
document.getElementById('formResto').addEventListener('submit', async function(e) {
    e.preventDefault(); // Mencegah halaman refresh

    const submitBtn = this.querySelector('button[type="submit"]');
    submitBtn.disabled = true;
    submitBtn.innerHTML = '⏳ Menyimpan...';

    try {
        const formData = new FormData(this);
        const response = await fetch("{{ route('admin.resto.update') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Lokasi resto telah diperbarui di database.',
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            throw new Error(data.message || 'Terjadi kesalahan');
        }
    } catch (error) {
        console.error(error);
        Swal.fire('Error', 'Gagal menyimpan data ke database. Cek koneksi atau Controller kamu.', 'error');
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = 'Simpan Lokasi Resto';
    }
});
</script>
@endpush
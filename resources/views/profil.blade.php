@extends('landing-page.landing-page')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-5xl mx-auto mt-24 p-6 bg-white rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Profil Saya</h2>

    {{-- Profil User --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="font-semibold">Nama:</p>
            <p>{{ $user->name }}</p>
        </div>
        <div>
            <p class="font-semibold">Email:</p>
            <p>{{ $user->email }}</p>
        </div>
        <div>
            <p class="font-semibold">Jenis Kelamin:</p>
            <p>{{ $user->jenis_kelamin ?? '-' }}</p>
        </div>
        <div>
            <p class="font-semibold">Umur:</p>
            <p>{{ $umur ?? '-' }} Tahun</p>
        </div>
    </div>

    <hr class="my-6">

    {{-- Alamat User --}}
    <h3 class="text-xl font-semibold mb-4">Alamat</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @forelse($alamat as $a)
        <div class="border p-4 rounded-lg bg-gray-50">
            <p class="font-semibold">{{ $a->label }} - {{ $a->penerima }}</p>
            <p>{{ $a->alamat }}, {{ $a->kota }}, {{ $a->provinsi }}, {{ $a->kode_pos }}</p>
            <p>📞 {{ $a->telepon }}</p>
            <div class="mt-2 flex gap-2">
                {{-- Edit alamat --}}
                <a href="{{ route('profil.alamat.edit', $a->id) }}" class="px-2 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition">Edit</a>

                {{-- Hapus alamat --}}
                <form action="{{ route('profil.alamat.delete', $a->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">Hapus</button>
                </form>
            </div>
        </div>
        @empty
        <p>Belum ada alamat.</p>
        @endforelse
    </div>

    {{-- Tambah Alamat --}}
    <div class="mt-6">
        <a href="{{ route('profil.alamat.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">Tambah Alamat Baru</a>
    </div>
</div>
@endsection

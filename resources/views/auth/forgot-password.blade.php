@extends('auth.template.template-auth')
@section('title', 'Lupa Sandi Coffee Sarongge')

@section('forgot')
<!-- Mobile version -->
<div class="md:hidden flex flex-col items-center justify-center min-h-screen bg-cover bg-center"
     style="background-image: url('{{ asset('uploads/back-login.jpg') }}')">
  <div class="w-full px-6">
    
    <!-- Header Logo -->
    <div class="text-center mb-6 bg-white p-4 rounded-lg ring-4 ring-[#5A3A1A]">
      <img src="{{ asset('uploads/logo2.png') }}" 
           alt="Coffee Logo" 
           class="w-64 h-auto mx-auto">
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('send.otp') }}" autocomplete="off" class="space-y-4 bg-white p-6 rounded-lg ring-2 ring-[#5A3A1A] shadow-md">
        @csrf

        <!-- Email atau No HP -->
        <div class="relative">
            <img src="{{ asset('uploads/email1.png') }}" alt="Email Icon"
                 class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5">
            <input type="text" name="identifier" placeholder="Masukkan Email atau No. HP"
                   value="{{ old('identifier') }}"
                   class="w-full pl-12 pr-4 py-2 rounded-full ring-2 ring-[#5A3A1A] focus:outline-none text-gray-800">
        </div>

        @error('identifier')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <button type="submit"
                class="w-full bg-[#5A3A1A] text-white py-2 rounded-full hover:bg-[#7b5a3a] transition">
            Kirim OTP
        </button>
    </form>

    <!-- Kembali ke login -->
    <p class="text-center mt-4 text-gray-800">
        <a href="{{ route('login') }}" class="hover:underline text-[#5A3A1A]">Kembali ke Login</a>
    </p>
  </div>
</div>

<!-- Desktop version -->
<div class="hidden md:flex items-center justify-center min-h-screen bg-cover bg-center"
     style="background-image: url('{{ asset('uploads/bg-web.png') }}')">
  <div class="bg-[#A15F3B] bg-opacity-90 rounded-3xl shadow-2xl p-10 w-1/3">
    
    <!-- Header Logo -->
    <div class="text-center mb-8 bg-white p-4 rounded-lg ring-2 ring-[#5A3A1A]">
      <img src="{{ asset('uploads/logo2.png') }}" 
           alt="Coffee Logo" 
           class="w-56 h-auto mx-auto">
    </div>

    <!-- Form -->
    <form method="POST" action="{{ route('send.otp') }}" autocomplete="off" class="space-y-4">
        @csrf

        <!-- Email atau No HP -->
        <div class="relative">
            <img src="{{ asset('uploads/email1.png') }}" alt="Email Icon"
                 class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5">
            <input type="text" name="identifier" placeholder="Masukkan Email atau No. HP"
                   value="{{ old('identifier') }}"
                   class="w-full pl-12 pr-4 py-2 rounded-full ring-2 ring-[#5A3A1A] focus:outline-none text-gray-800">
        </div>

        @error('identifier')
            <p class="text-red-500 text-sm">{{ $message }}</p>
        @enderror

        <button type="submit"
                class="w-full bg-[#5A3A1A] text-white py-2 rounded-full hover:bg-[#7b5a3a] transition">
            Kirim OTP
        </button>
    </form>

    <!-- Kembali ke login -->
    <p class="text-center mt-4 text-gray-100">
        <a href="{{ route('login') }}" class="hover:underline text-white">Kembali ke Login</a>
    </p>
  </div>
</div>
@endsection

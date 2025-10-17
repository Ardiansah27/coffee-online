@extends('auth.template.template-auth')
@section('title', 'Login Coffee Sarongge')

@section('reset')


<!-- Mobile version -->
<div class="md:hidden flex flex-col items-center justify-center min-h-screen bg-cover bg-center"
     style="background-image: url('{{ asset('uploads/back-login.jpg') }}')">
  <div class="w-full px-6">
    
    <!-- Header -->
    <div class="text-center mb-3 bg-white p-4 rounded-lg ring-4 ring-[#5A3A1A]">
      <img src="{{ asset('uploads/logo2.png') }}" 
           alt="Coffee Logo" 
           class="w-full h-auto mx-auto">
    </div>

    <!-- Desktop version -->
<div class="hidden md:flex items-center justify-center min-h-screen bg-cover bg-center"
     style="background-image: url('{{ asset('uploads/bg-web.png') }}')">
  <div class="bg-[#A15F3B] bg-opacity-90 rounded-3xl shadow-2xl p-10 w-1/3">
    
   <div class="text-center mb-10 bg-white p-4 rounded-lg">
  <img src="{{ asset('uploads/logo2.png') }}" 
       alt="Coffee Logo" 
       class="w-full h-auto mx-auto">
</div>

    <h1 class="text-4xl font-bold mt-4 w-full text-center mb-3 text-[#5A3A1A]">Lupa Sandi</h1>
\

    <form method="POST" action="{{ route('reset.password') }}" autocomplete="off" class="space-y-4">
        @csrf

        <!-- OTP -->
        <div class="relative">
            <img src="{{ asset('uploads/password.png') }}" alt="OTP Icon"
                 class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5">
            <input type="text" name="otp" placeholder="Masukkan Kode OTP"
                   class="w-full pl-12 pr-4 py-2 rounded-full ring-2 ring-[#5A3A1A] focus:outline-none text-gray-800">
        </div>

        <!-- Password Baru -->
        <div class="relative">
            <img src="{{ asset('uploads/password.png') }}" alt="Password Icon"
                 class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5">
            <input type="password" name="password" placeholder="Masukkan Password Baru"
                   class="w-full pl-12 pr-4 py-2 rounded-full ring-2 ring-[#5A3A1A] focus:outline-none text-gray-800">
        </div>

        <button type="submit"
                class="w-full bg-[#5A3A1A] text-white py-2 rounded-full hover:bg-[#7b5a3a] transition">
            Reset Password
        </button>
    </form>
  </div>
</div>
@endsection

@extends('auth.template.template-auth')
@section('title', 'Register Coffee Enyong')

@section('layout-register')

<!-- Mobile version -->
<div class="md:hidden flex flex-col items-center justify-center min-h-screen bg-cover bg-center"
     style="background-image: url('{{ asset('uploads/back-login.jpg') }}')">
  <div class="w-full px-6">

    <!-- Header -->
    <div class="text-center mb-3 bg-white p-4 rounded-lg ring-4 ring-[#5A3A1A]">
      <img src="{{ asset('uploads/logo2.png') }}" alt="Coffee Logo" class="w-full h-auto mx-auto">
    </div>

    <h1 class="text-4xl font-bold mt-4 w-full text-center mb-3 text-[#5A3A1A]">Register</h1>

    <!-- Form Mobile -->
    <form class="space-y-4" method="POST" action="{{ route('register') }}" autocomplete="off">
      @csrf

      <!-- Nama Akun -->
      <div class="relative">
        <img src="{{ asset('uploads/user.png') }}" alt="User Icon"
             class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5">
        <input type="text" id="name" name="name" placeholder="Nama Akun"
               autocomplete="off" value=""
               class="w-full pl-12 pr-4 py-2 rounded-full ring-2 ring-[#5A3A1A] focus:outline-none text-gray-800">
      </div>

      <!-- Email -->
      <div class="relative">
        <img src="{{ asset('uploads/email1.png') }}" alt="Email Icon"
             class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5">
        <input type="email" id="email" name="email" placeholder="Masukkan Email"
               autocomplete="off" value=""
               class="w-full pl-12 pr-4 py-2 rounded-full ring-2 ring-[#5A3A1A] focus:outline-none text-gray-800">
      </div>

      <!-- No. Telpon -->
      <div class="relative">
        <img src="{{ asset('uploads/telpon.png') }}" alt="Phone Icon"
             class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5">
        <input type="text" id="phone" name="phone" placeholder="Masukkan No. Telpon"
               autocomplete="off" value=""
               class="w-full pl-12 pr-4 py-2 rounded-full ring-2 ring-[#5A3A1A] focus:outline-none text-gray-800">
      </div>

      <!-- Password + Konfirmasi -->
      <div class="relative">
        <img src="{{ asset('uploads/password.png') }}" alt="Password Icon"
             class="absolute left-4 top-[22%] transform -translate-y-1/2 w-5 h-5">
        <input type="password" id="password-mobile" name="password" placeholder="Password"
               autocomplete="new-password"
               class="w-full pl-12 pr-10 py-2 mb-3 rounded-full ring-2 ring-[#5A3A1A] focus:outline-none text-gray-800">

 <!-- Icon password kiri untuk konfirmasi -->
  <img src="{{ asset('uploads/password.png') }}" alt="Password Icon"
       class="absolute left-4 top-[77%] transform -translate-y-1/2 w-5 h-5">


        <input type="password" id="password-confirm-mobile" name="password_confirmation"
               placeholder="Konfirmasi Password"
               autocomplete="new-password"
               class="w-full pl-12 pr-10 py-2 rounded-full ring-2 ring-[#5A3A1A] focus:outline-none text-gray-800">

        <!-- Satu icon mata untuk keduanya -->
        <div class="absolute right-4 top-[9%] cursor-pointer"
             onclick="toggleBothPasswords('password-mobile', 'password-confirm-mobile', 'eye-icon-mobile')">
          <img id="eye-icon-mobile" src="{{ asset('uploads/mata1.png') }}" alt="Eye Icon" class="w-6 h-6">
        </div>
      </div>

      <!-- Button Register -->
      <button type="submit"
              class="w-full bg-[#5A3A1A] text-white py-2 rounded-full hover:bg-[#3f2612] transition duration-300">
        Register
      </button>

    </form>

    <!-- Footer -->
    <p class="text-center text-[#5A3A1A] text-lg mt-4">
      Sudah punya akun?
      <a href="{{ route('login') }}" class="underline font-semibold text-[#5A3A1A] hover:text-white">Login</a>
    </p>

  </div>
</div>

<!-- Desktop version -->
<div class="hidden md:flex items-center justify-center min-h-screen bg-cover bg-center"
     style="background-image: url('{{ asset('uploads/bg-web.png') }}')">
  <div class="bg-[#A15F3B] bg-opacity-90 rounded-3xl shadow-2xl p-10 w-1/3">

    <!-- Header -->
    <div class="text-center mb-10 bg-white p-4 rounded-lg ring-4 ring-[#5A3A1A]">
      <img src="{{ asset('uploads/logo2.png') }}" alt="Coffee Logo" class="w-full h-auto mx-auto">
    </div>

    <h1 class="text-4xl font-bold mt-4 w-full text-center mb-3 text-white">Register</h1>

    <!-- Form Desktop -->
    <form class="space-y-4" method="POST" action="{{ route('register') }}" autocomplete="off">
      @csrf

      <!-- Nama Akun -->
      <div class="relative">
        <img src="{{ asset('uploads/user1.png') }}" alt="User Icon"
             class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6">
        <input type="text" id="name-desktop" name="name" placeholder="Nama Akun"
               autocomplete="off" value=""
               class="w-full pl-14 pr-10 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-[#5A3A1A] text-black">
      </div>

      <!-- Email -->
      <div class="relative">
        <img src="{{ asset('uploads/email1.png') }}" alt="Email Icon"
             class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6">
        <input type="email" id="email-desktop" name="email" placeholder="Masukkan Email"
               autocomplete="off" value=""
               class="w-full pl-14 pr-10 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-[#5A3A1A] text-black">
      </div>

      <!-- No. Telpon -->
      <div class="relative">
        <img src="{{ asset('uploads/telpon.png') }}" alt="Phone Icon"
             class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6">
        <input type="text" id="phone-desktop" name="phone" placeholder="Masukkan No. Telpon"
               autocomplete="off" value=""
               class="w-full pl-14 pr-10 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-[#5A3A1A] text-black">
      </div>

      <!-- Password + Konfirmasi -->
    <!-- PASSWORD & KONFIRMASI PASSWORD -->
<div class="relative">
  <!-- Icon password kiri -->
  <img src="{{ asset('uploads/password.png') }}" alt="Password Icon"
       class="absolute left-4 top-[21%] transform -translate-y-1/2 w-6 h-6">

  <!-- Field Password -->
  <input type="password" id="password-desktop" name="password" placeholder="Password"
         autocomplete="new-password"
         class="w-full pl-14 pr-10 py-3 mb-4 rounded-full focus:outline-none focus:ring-2 focus:ring-[#5A3A1A] text-black">

  <!-- Icon password kiri untuk konfirmasi -->
  <img src="{{ asset('uploads/password.png') }}" alt="Password Icon"
       class="absolute left-4 top-[77%] transform -translate-y-1/2 w-6 h-6">

  <!-- Field Konfirmasi Password -->
  <input type="password" id="password-confirm-desktop" name="password_confirmation"
         placeholder="Konfirmasi Password"
         autocomplete="new-password"
         class="w-full pl-14 pr-10 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-[#5A3A1A] text-black">

  <!-- Icon mata satu untuk keduanya -->
  <div class="absolute right-4 top-[22%] transform -translate-y-1/2 cursor-pointer"
       onclick="toggleBothPasswords('password-desktop', 'password-confirm-desktop', 'eye-icon-desktop')">
    <img id="eye-icon-desktop" src="{{ asset('uploads/mata1.png') }}" alt="Eye Icon" class="w-6 h-6">
  </div>
</div>


      <!-- Button Register -->
      <button type="submit"
              class="w-full bg-[#5A3A1A] text-xl text-white font-bold py-3 rounded-full hover:bg-[#3f2612] transition duration-300">
        Register
      </button>
    </form>

    <!-- Footer -->
    <p class="text-center text-white text-lg mt-6">
      Sudah punya akun?
      <a href="{{ route('login') }}" class="underline font-semibold text-white hover:text-[#5A3A1A]">Login</a>
    </p>
  </div>
</div>

<!-- Script Show/Hide Password -->
<script>
function toggleBothPasswords(pass1Id, pass2Id, eyeId) {
  const pass1 = document.getElementById(pass1Id);
  const pass2 = document.getElementById(pass2Id);
  const eyeIcon = document.getElementById(eyeId);
  if (!pass1 || !pass2 || !eyeIcon) return;

  const isHidden = pass1.type === "password" && pass2.type === "password";

  if (isHidden) {
    pass1.type = "text";
    pass2.type = "text";
    eyeIcon.src = "{{ asset('uploads/mata2.png') }}";
  } else {
    pass1.type = "password";
    pass2.type = "password";
    eyeIcon.src = "{{ asset('uploads/mata1.png') }}";
  }
}
</script>

@endsection

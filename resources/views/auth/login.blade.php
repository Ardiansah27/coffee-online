@extends('auth.template.template-auth')
@section('title', 'Login Coffee Enyong')

@section('layout-login')

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

    <h1 class="text-4xl font-bold mt-4 w-full text-center mb-3 text-[#5A3A1A]">Login</h1>

    <!-- Form Mobile -->
    <form class="space-y-4" autocomplete="off" method="POST" onsubmit="return false;">
      @csrf

      <!-- Hidden dummy fields (trik anti autofill) -->
      <input type="text" name="fakeusernameremembered" style="display:none;">
      <input type="password" name="fakepasswordremembered" style="display:none;">

      <!-- Email -->
      <div class="relative">
        <img src="{{ asset('uploads/email1.png') }}" alt="Email Icon"
             class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5">
        <input type="text" id="email" name="email" placeholder="Email"
               value="" autocomplete="off" autocorrect="off" spellcheck="false"
               class="w-full pl-12 pr-4 py-2 rounded-full ring-2 ring-[#5A3A1A] text-gray-800 focus:outline-none">
      </div>

      <!-- Password -->
      <div class="relative">
        <img src="{{ asset('uploads/password.png') }}" alt="Password Icon"
             class="absolute left-4 top-1/4 transform -translate-y-1/2 w-5 h-5">
        <input type="password" id="password-mobile" name="password" placeholder="Password"
               value="" autocomplete="new-password"
               class="w-full pl-12 pr-10 py-2 rounded-full ring-2 ring-[#5A3A1A] text-gray-800 focus:outline-none">

        <!-- Eye icon -->
        <div class="absolute right-4 top-[27%] transform -translate-y-1/2 cursor-pointer"
             onclick="togglePassword('password-mobile', 'eye-icon-mobile')">
          <img id="eye-icon-mobile" src="{{ asset('uploads/mata1.png') }}"
               alt="Eye Icon" class="w-6 h-6">
        </div>

        <!-- Link lupa password -->
        <p class="text-right mt-2">
          <a href="#" class="text-lg text-[#5A3A1A] hover:underline">Lupa Password?</a>
        </p>
      </div>

      <!-- Tombol Login -->
      <button type="submit"
              class="w-full bg-[#5A3A1A] text-white py-2 rounded-full hover:bg-[#3f2612] transition duration-300">
        Login
      </button>

      <!-- Tombol Login dengan Google -->
      <button type="button"
              class="w-full flex items-center justify-center gap-3 bg-white text-gray-800 font-semibold py-3 rounded-full ring-2 ring-[#5A3A1A] shadow-md hover:bg-gray-100 transition duration-300 active:bg-[#5A3A1A] active:text-white">
        <img src="{{ asset('uploads/google2.png') }}" alt="Google Logo" class="w-5 h-5">
        <span>Login dengan Google</span>
      </button>
    </form>

    <!-- Footer -->
    <p class="text-center text-[#5A3A1A] text-lg mt-4 rounded">
      Don't have an account? 
      <a href="{{ route('register') }}" class="underline font-semibold text-[#5A3A1A] hover:text-white">
        Sign Up
      </a>
    </p>

  </div>
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






<h1 class="text-4xl font-bold text-white mt-4 w-full text-center mb-3">Login</h1>

    <!-- Form Desktop -->
    <form class="space-y-6" autocomplete="off">
      <!-- Email -->
      <div class="relative">
        <img src="{{ asset('uploads/email1.png') }}" alt="Email Icon" class="absolute left-4 top-1/2 transform -translate-y-1/2 w-6 h-6">
        <input type="email" id="email" name="email" placeholder="Massukan Email Anda" value="" autocomplete="off"
               class="w-full pl-14 pr-10 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-[#5A3A1A] text-black">
      </div>

     <div class="relative">
  <img src="{{ asset('uploads/password.png') }}" alt="Password Icon" class="absolute left-4 top-[27%] transform -translate-y-1/2 w-6 h-6">
  <input type="password" id="password-desktop" name="password" placeholder="Masukan Password Anda" value="" autocomplete="new-password"
         class="w-full pl-14 pr-10 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-[#5A3A1A] text-black">
  <div class="absolute right-4 top-[29%] transform -translate-y-1/2 cursor-pointer"
       onclick="togglePassword('password-desktop', 'eye-icon-desktop')">
    <img id="eye-icon-desktop" src="{{ asset('uploads/mata1.png') }}" alt="Eye Icon" class="w-6 h-6">
  </div>
  <!-- Link lupa password langsung menempel ke field -->
<p class="text-right mt-2 ">
  <a href="#" class="text-lg text-white hover:underline">Lupa Password?</a>
</p>

</div>




      <button type="submit" class="w-full bg-[#5A3A1A] text-xl text-white font-bold py-3 rounded-full hover:bg-[#3f2612] transition duration-300">Login</button>

<button class="w-full flex items-center justify-center gap-3 bg-white text-gray-800 font-semibold py-3 rounded-full ring-2 ring-[#5A3A1A] shadow-md transition duration-300 hover:bg-[#3f2612] hover:text-white">
  <img src="{{ asset('uploads/google2.png') }}" alt="Google Logo" class="w-5 h-5">
  <span>Login dengan Google</span>
</button>

    </form>

    <!-- Footer -->
    <!-- Desktop footer -->
<p class="text-center text-white text-lg mt-6">
  Don't have an account? 
<a href="{{ route('register') }}" class="underline font-semibold text-[#5A3A1A] hover:text-white">Sign Up</a>

</p>

  </div>
</div>

<!-- Script Show/Hide Password -->
<script>
function togglePassword(passwordId, eyeId) {
  const password = document.getElementById(passwordId);
  const eyeIcon = document.getElementById(eyeId);
  if (!password || !eyeIcon) return;

  if (password.type === "password") {
    password.type = "text";
    eyeIcon.src = "{{ asset('uploads/mata2.png') }}";
  } else {
    password.type = "password";
    eyeIcon.src = "{{ asset('uploads/mata1.png') }}";
  }
}
</script>


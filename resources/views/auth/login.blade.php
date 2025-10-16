<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Coffee Enyong - Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen font-sans">

  <!-- Mobile version: full screen background (smaller than 876px) -->
  <div class="md:hidden flex flex-col items-center justify-center min-h-screen bg-cover bg-center"
       style="background-image: url('{{ asset('uploads/back-login.jpg') }}')">
    <div class="w-full px-6">
      <div class="bg-[#A15F3B] bg-opacity-90 rounded-3xl shadow-lg p-6">
        <!-- Header -->
         <div class="text-center ">
      <div class="flex justify-center">
        <img src="{{ asset('uploads/logo2.png') }}" alt="Coffee Logo" class="w-50 h-24   ">
      </div>
  
       <h1 class="text-4xl font-bold text-white mt-4  ">Login</h1>
    </div>

        <!-- Login Form -->
        <form class="space-y-4">
          <div>
            <label class="block text-sm text-white mb-1" for="username">Username</label>
            <input type="text" id="username" placeholder="Username" class="w-full px-4 py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-[#F4E9DC]">
          </div>
          <div>
            <label class="block text-sm text-white mb-1" for="password">Password</label>
            <input type="password" id="password" placeholder="Password" class="w-full px-4 py-2 rounded-full focus:outline-none focus:ring-2 focus:ring-[#F4E9DC]">
          </div>
          <button type="submit" class="w-full bg-[#5A3A1A] text-white py-2 rounded-full hover:bg-[#3f2612] transition duration-300">Login</button>
        </form>

        <!-- Footer -->
        <p class="text-center text-white text-sm mt-4">
          Don't have an account? <a href="#" class="underline font-semibold">Sign Up</a>
        </p>
      </div>
    </div>
  </div>

 <!-- Desktop version: centered card with background -->
<div class="hidden md:flex items-center justify-center min-h-screen bg-cover bg-center"
     style="background-image: url('{{ asset('uploads/bg-web.png') }}');">

  <div class="bg-[#A15F3B] bg-opacity-90 rounded-3xl shadow-2xl p-10 w-1/3">
    
    <!-- Header -->
    <div class="text-center ">
     
      <div class="flex justify-center">
        <img src="{{ asset('uploads/logo2.png') }}" alt="Coffee Logo" class="w-50 h-24   ">
      </div>
      <br>
       <h1 class="text-4xl font-bold text-white mt-5 ">Login</h1>
    </div>

      <!-- Login Form -->
    <form class="space-y-6">

      <!-- Email -->
      <div class="relative">
        <label class="block text-sm text-white mb-1" for="email">Email</label>
        <input type="email" id="email" placeholder="Enter your email"
               class="w-full pl-16 pr-4 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-[#5A3A1A] text-black">
        <!-- Icon email -->
        <div class="absolute left-3 top-[65%] transform -translate-y-1/2">
          <img src="{{ asset('uploads/email1.png') }}" alt="Email Icon" class="w-9 h-9">
        </div>
      </div>

      <!-- Password -->
      <div class="relative">
        <label class="block text-sm text-white mb-1" for="password">Password</label>
        <input type="password" id="password" placeholder="Enter your password"
               class="w-full pl-16 pr-4 py-3 rounded-full focus:outline-none focus:ring-2 focus:ring-[#5A3A1A] text-black">
        <!-- Icon password -->
        <div class="absolute left-3 top-[65%] transform -translate-y-1/2">
          <img src="{{ asset('uploads/password.png') }}" alt="Password Icon" class="w-9 h-9">
        </div>
        <!-- Icon mata (show/hide) -->
        <div class="absolute right-3 top-[65%] transform -translate-y-1/2 cursor-pointer" onclick="togglePassword()">
          <img id="eye-icon" src="{{ asset('uploads/mata1.png') }}" alt="Eye Icon" class="w-6 h-6">
        </div>
      </div>

      <button type="submit"
              class="w-full bg-[#5A3A1A] text-white font-bold py-3 rounded-full hover:bg-[#3f2612] transition duration-300">
        Login
      </button>

    </form>

    <!-- Footer -->
    <p class="text-center text-white text-sm mt-6">
      Don't have an account? <a href="#" class="underline font-semibold text-[#5A3A1A]">Sign Up</a>
    </p>

  </div>
</div>

<script>
  function togglePassword() {
    const passwordInput = document.getElementById('password');
    const eyeIcon = document.getElementById('eye-icon');

    if(passwordInput.type === 'password') {
      passwordInput.type = 'text';
      eyeIcon.src = "{{ asset('uploads/icon-eye-off.png') }}";
    } else {
      passwordInput.type = 'password';
      eyeIcon.src = "{{ asset('uploads/icon-eye.png') }}";
    }
  }
</script>

</body>
</html>

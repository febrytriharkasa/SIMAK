<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - SIMAK</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-cover bg-center flex items-center justify-center"
      style="background-image: url('{{ asset('bg/bg0.jpg') }}');">

  <!-- Kotak Login -->
  <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl w-[400px] p-8">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
      <img src="{{ asset('logo/intel amfibi.png') }}" alt="Logo" 
           class="h-16 w-16 object-contain rounded-full shadow-md">
    </div>

    <!-- Judul -->
    <h2 class="text-center text-2xl font-bold text-gray-800">Sign in with email</h2>
    <p class="text-center text-gray-500 text-sm mb-6">
      Masukkan email dan password untuk masuk ke dashboard.
    </p>

    <!-- Form -->
    <form action="{{ route('login') }}" method="POST" class="space-y-4">
      @csrf
      <!-- Email -->
      <div>
        <input type="email" name="email" placeholder="Email" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                 focus:ring-2 focus:ring-sky-400 focus:outline-none">
      </div>

      <!-- Password + Eye -->
      <div class="relative">
        <input id="password" type="password" name="password" placeholder="Password" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg 
                 focus:ring-2 focus:ring-sky-400 focus:outline-none pr-10">
        
        <!-- Tombol Eye -->
        <button type="button" onclick="togglePassword()" 
          class="absolute right-3 top-2.5 text-gray-500 hover:text-sky-600">
          <!-- Eye Open -->
          <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" 
               class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 
                 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 
                 7-4.477 0-8.268-2.943-9.542-7z" />
          </svg>
          <!-- Eye Closed -->
          <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" 
               class="h-5 w-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 
                 0-8.268-2.943-9.542-7a9.956 9.956 0 
                 012.122-3.592m3.977-2.56A9.953 9.953 0 
                 0112 5c4.477 0 8.268 2.943 9.542 
                 7a9.956 9.956 0 01-4.043 5.132M15 
                 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 3l18 18" />
          </svg>
        </button>
      </div>

      <!-- Tombol Login -->
      <button type="submit"
        class="w-full bg-black text-white py-2 rounded-lg font-semibold 
               hover:bg-gray-800 transition">
        Login
      </button>

      <!-- Lupa Password + Register -->
      <div class="flex justify-between text-sm mt-2">
        <a href="{{ route('password.request') }}" 
           class="text-sky-600 hover:underline">
          Lupa Password?
        </a>
        <a href="{{ route('register') }}" 
           class="text-sky-600 hover:underline">
            Belum punya akun? Daftar
        </a>
      </div>
    </form>
  </div>

  <!-- Script Toggle Password -->
  <script>
    function togglePassword() {
      const input = document.getElementById('password');
      const eyeOpen = document.getElementById('eyeOpen');
      const eyeClosed = document.getElementById('eyeClosed');

      if (input.type === "password") {
        input.type = "text";
        eyeOpen.classList.add("hidden");
        eyeClosed.classList.remove("hidden");
      } else {
        input.type = "password";
        eyeOpen.classList.remove("hidden");
        eyeClosed.classList.add("hidden");
      }
    }
  </script>

</body>
</html>

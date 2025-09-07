<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - SIMAK</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="h-screen bg-cover bg-center flex items-center justify-center"
      style="background-image: url('{{ asset('bg/bg0.jpg') }}');">

  <!-- Card Register -->
  <div class="bg-white/80 backdrop-blur-md shadow-xl rounded-2xl w-[400px] p-8">
    <!-- Logo -->
    <div class="flex justify-center mb-6">
      <img src="{{ asset('logo/intel amfibi.png') }}" alt="Logo"
           class="h-16 w-16 object-contain rounded-full shadow-md">
    </div>

    <!-- Judul -->
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Create an Account</h2>

    <!-- Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
      @csrf

      <!-- Name -->
      <div>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus autocomplete="name"
          placeholder="Full Name"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-400 focus:outline-none">
      </div>

      <!-- Email -->
      <div>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="username"
          placeholder="Email"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-400 focus:outline-none">
      </div>

      <!-- Password -->
      <div class="relative">
        <input id="password" name="password" type="password" required autocomplete="new-password"
          placeholder="Password"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-400 focus:outline-none">
        <button type="button" onclick="togglePassword('password', this)" 
          class="absolute right-3 top-2.5 text-gray-500 hover:text-sky-600">
          👁
        </button>
      </div>

      <!-- Confirm Password -->
      <div class="relative">
        <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password"
          placeholder="Confirm Password"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-400 focus:outline-none">
        <button type="button" onclick="togglePassword('password_confirmation', this)" 
          class="absolute right-3 top-2.5 text-gray-500 hover:text-sky-600">
          👁
        </button>
      </div>

      <!-- Role -->
      <div>
        <select id="role" name="role" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-400 focus:outline-none">
          <option value="">-- Select Jabatan --</option>
          <option value="guru_tk">Guru TK</option>
          <option value="guru_mi">Guru MI</option>
        </select>
      </div>

      <!-- Button -->
      <button type="submit"
        class="w-full bg-black text-white py-2 rounded-lg font-semibold hover:bg-gray-800 transition">
        Register
      </button>
    </form>

    <!-- Divider -->
    <div class="flex items-center my-6">
      <div class="flex-grow h-px bg-gray-300"></div>
      <span class="px-3 text-sm text-gray-500">Already registered?</span>
      <div class="flex-grow h-px bg-gray-300"></div>
    </div>

    <!-- Login Link -->
    <div class="text-center">
      <a href="{{ route('login') }}" class="text-sm font-semibold text-sky-600 hover:underline">
        Login here
      </a>
    </div>
  </div>

  <!-- Script Eye Toggle -->
  <script>
    function togglePassword(id, btn) {
      const input = document.getElementById(id);
      if (input.type === "password") {
        input.type = "text";
        btn.textContent = "🙈";
      } else {
        input.type = "password";
        btn.textContent = "👁";
      }
    }
  </script>

</body>
</html>

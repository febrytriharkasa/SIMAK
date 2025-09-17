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
    <h2 class="text-2xl font-bold text-gray-800 text-center mb-6">Registrasi Akun</h2>

    <!-- Form -->
    <form method="POST" action="{{ route('register') }}" class="space-y-4">
      @csrf

      <!-- Nama -->
      <div>
        <input id="name" name="name" type="text" value="{{ old('name') }}" required
          placeholder="Nama"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-400 focus:outline-none">
      </div>

      <!-- NIP -->
      <div>
        <input id="nip" name="nip" type="text" value="{{ old('nip') }}" required
          placeholder="NIP"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-400 focus:outline-none">
      </div>

      <!-- Email -->
      <div>
        <input id="email" name="email" type="email" value="{{ old('email') }}" required
          placeholder="Email"
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-400 focus:outline-none">
      </div>

      <!-- Role -->
      <div>
        <select id="role" name="role" required
          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-400 focus:outline-none">
          <option value="">-- Pilih Jabatan --</option>
          <option value="guru_tk">Guru TK</option>
          <option value="guru_mi">Guru MI</option>
        </select>
      </div>

      <!-- Button -->
      <button type="submit"
        class="w-full bg-black text-white py-2 rounded-lg font-semibold hover:bg-gray-800 transition">
        Daftar
      </button>
    </form>

    <!-- Divider -->
    <div class="flex items-center my-6">
      <div class="flex-grow h-px bg-gray-300"></div>
      <span class="px-3 text-sm text-gray-500">Sudah punya akun?</span>
      <div class="flex-grow h-px bg-gray-300"></div>
    </div>

    <!-- Login Link -->
    <div class="text-center">
      <a href="{{ route('login') }}" class="text-sm font-semibold text-sky-600 hover:underline">
        Login di sini
      </a>
    </div>
  </div>

</body>
</html>
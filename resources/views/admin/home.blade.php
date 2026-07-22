@extends('admin.layout.app')

@section('page_title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Stat Card 1 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Total Konsultasi</p>
            <h3 class="text-3xl font-bold text-gray-800">120</h3>
        </div>
        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
            <i class="fa-solid fa-stethoscope text-xl"></i>
        </div>
    </div>
    
    <!-- Stat Card 2 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Pesan Masuk</p>
            <h3 class="text-3xl font-bold text-gray-800">15</h3>
        </div>
        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-green-600">
            <i class="fa-solid fa-envelope text-xl"></i>
        </div>
    </div>

    <!-- Stat Card 3 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Total Berita</p>
            <h3 class="text-3xl font-bold text-gray-800">45</h3>
        </div>
        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-purple-600">
            <i class="fa-solid fa-newspaper text-xl"></i>
        </div>
    </div>

    <!-- Stat Card 4 -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex items-center justify-between hover:shadow-md transition-shadow">
        <div>
            <p class="text-sm font-medium text-gray-500 mb-1">Total Pengguna</p>
            <h3 class="text-3xl font-bold text-gray-800">89</h3>
        </div>
        <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-orange-600">
            <i class="fa-solid fa-users text-xl"></i>
        </div>
    </div>
</div>

<!-- Welcome Banner -->
<div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-8 text-white">
    <h2 class="text-3xl font-bold mb-2">Selamat Datang, {{ session('username') }}! 👋</h2>
    <p class="text-blue-100 text-lg max-w-2xl">
        Anda masuk sebagai <strong class="uppercase">{{ session('level') }}</strong>. Gunakan menu di sebelah kiri untuk mengelola konten, melayani konsultasi pengguna, dan mengatur konfigurasi aplikasi E-Konseling.
    </p>
    <div class="mt-6">
        <a href="#" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-blue-700 bg-white hover:bg-gray-50 shadow-sm transition-colors">
            Lihat Daftar Konsultasi Terbaru
        </a>
    </div>
</div>
@endsection

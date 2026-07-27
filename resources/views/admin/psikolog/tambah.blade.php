@extends('admin.layout.app')

@section('page_title', $title)

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-3xl">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center bg-gray-50">
        <h3 class="font-bold text-gray-800 text-lg">Form Tambah Psikolog</h3>
        <a href="{{ url('admin/manajemen_psikolog') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
            <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
        </a>
    </div>

    @if(session('message'))
        <div class="p-4 m-6 mb-0 rounded-lg">
            {!! session('message') !!}
        </div>
    @endif

    <div class="p-6">
        <form action="{{ url('admin/tambah_psikolog') }}" method="POST" class="space-y-5">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <!-- Kolom Kiri -->
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nama Lengkap & Gelar <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_lengkap" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow outline-none text-sm" placeholder="Contoh: dr. Budi Santoso, Sp.KJ" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
                        <input type="text" name="username" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow outline-none text-sm" placeholder="Contoh: budi_psikolog" required>
                        <p class="text-xs text-gray-500 mt-1">Digunakan untuk login oleh psikolog.</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow outline-none text-sm" placeholder="••••••••" required minlength="6">
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="space-y-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow outline-none text-sm" placeholder="contoh@email.com" required>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Nomor Telepon / WhatsApp <span class="text-red-500">*</span></label>
                        <input type="text" name="no_telp" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow outline-none text-sm" placeholder="08xxxxxxxxxx" required>
                    </div>
                </div>
            </div>

            <div class="pt-6 mt-6 border-t border-gray-100 flex gap-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-6 rounded-lg shadow-sm transition-colors font-medium">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Data
                </button>
                <button type="reset" class="bg-gray-100 hover:bg-gray-200 text-gray-700 py-2.5 px-6 rounded-lg transition-colors font-medium">
                    Reset
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

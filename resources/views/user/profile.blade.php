@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto mb-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="w-full lg:w-2/3">
            <!-- Breadcrumb -->
            <div class="text-sm text-gray-500 mb-6 flex items-center space-x-2">
                <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
                <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
                <span class="text-gray-800 font-medium">Profile Pengguna</span>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 pb-3 border-b-2 border-green-600">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 sm:mb-0">Profile Pengguna</h2>
                <a href="{{ url('user/edit_profile') }}" class="inline-flex items-center justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm shadow-sm">
                    <i class="fa-solid fa-pen-to-square mr-2"></i> Edit Profile
                </a>
            </div>

            @php 
                $nama = explode(' ', $row['nama_lengkap'] ?? '');
                $nama_belakang = isset($nama[1]) ? implode(' ', array_slice($nama, 1)) : '';
            @endphp 

            @if (($row['blokir'] ?? '') == 'Y')
                <div class="bg-red-50 text-red-800 border-l-4 border-red-500 p-4 rounded-md mb-6 shadow-sm">
                    <strong><i class="fa-solid fa-triangle-exclamation mr-2"></i> PENTING!</strong> Akun anda belum aktif!, silahkan menunggu paling lambat 1x24 jam untuk di verifikasi oleh admin.
                </div>
            @endif
            
            <div class="bg-blue-50 text-blue-800 border-l-4 border-blue-500 p-4 rounded-md mb-6 shadow-sm text-sm">
                <strong><i class="fa-solid fa-circle-info mr-2"></i> PENTING!</strong> Pastikan data anda dibawah ini sesuai dengan data kartu identitas, dan bisa dipertanggung jawabkan jika nanti ada masalah. Terima kasih,.. ^_^
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
                <div class="p-6 sm:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6">
                        <div class="border-b border-gray-100 pb-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Username</span>
                            <span class="text-gray-900 font-medium">{{ $row['username'] ?? '-' }}</span>
                        </div>
                        <div class="border-b border-gray-100 pb-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Password</span>
                            <span class="text-gray-900 font-medium tracking-widest text-lg leading-none">••••••••</span>
                        </div>
                        <div class="border-b border-gray-100 pb-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Depan</span>
                            <span class="text-gray-900 font-medium">{{ $nama[0] ?? '-' }}</span>
                        </div>
                        <div class="border-b border-gray-100 pb-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Nama Belakang</span>
                            <span class="text-gray-900 font-medium">{{ $nama_belakang ?: '-' }}</span>
                        </div>
                        <div class="border-b border-gray-100 pb-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Alamat Email</span>
                            <span class="text-gray-900 font-medium">{{ $row['email'] ?? '-' }}</span>
                        </div>
                        <div class="border-b border-gray-100 pb-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">No Telpon</span>
                            <span class="text-gray-900 font-medium">{{ $row['no_telp'] ?? '-' }}</span>
                        </div>
                        <div class="border-b border-gray-100 pb-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Jenis Kelamin</span>
                            <span class="text-gray-900 font-medium">{{ $row['jenis_kelamin'] ?? '-' }}</span>
                        </div>
                        <div class="border-b border-gray-100 pb-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tempat Lahir</span>
                            <span class="text-gray-900 font-medium">{{ $row['tempat_lahir'] ?? '-' }}</span>
                        </div>
                        <div class="border-b border-gray-100 pb-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Tanggal Lahir</span>
                            <span class="text-gray-900 font-medium">{{ $row['tanggal_lahir'] ?? '-' }}</span>
                        </div>
                        <div class="border-b border-gray-100 pb-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Status Pernikahan</span>
                            <span class="text-gray-900 font-medium">{{ $row['status_kawin'] ?? '-' }}</span>
                        </div>
                        <div class="border-b border-gray-100 pb-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Agama</span>
                            <span class="text-gray-900 font-medium">{{ $row['agama'] ?? '-' }}</span>
                        </div>
                        <div class="border-b border-gray-100 pb-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Pekerjaan / Perangkat Daerah</span>
                            <span class="text-gray-900 font-medium">{!! nl2br(e($row['perangkat_daerah'] ?? '-')) !!}</span>
                        </div>
                        <div class="md:col-span-2 border-b border-gray-100 pb-3">
                            <span class="block text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1">Alamat Lengkap</span>
                            <span class="text-gray-900 font-medium">{{ $row['alamat_lengkap'] ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ url('user/konsultasi') }}" class="block w-full bg-green-600 hover:bg-green-700 text-white text-center font-bold py-4 px-6 rounded-xl shadow-md hover:shadow-lg transition-all transform hover:-translate-y-1">
                <i class="fa-solid fa-comments mr-2"></i> Konsultasi Sekarang!
            </a>
        </div>

        <!-- Sidebar -->
        <div class="w-full lg:w-1/3">
            @include('partials.sidebar')
        </div>
    </div>
</div>
@endsection

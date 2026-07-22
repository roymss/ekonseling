@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto mb-12">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <span class="text-gray-800 font-medium">{{ $title ?? 'Daftar Psikolog' }}</span>
    </div>

    <h2 class="text-3xl font-bold text-gray-900 mb-8 pb-3 border-b-2 border-green-600 inline-block">{{ $title ?? 'Daftar Psikolog' }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
        @foreach ($psikolog as $row)
            @php
                $foto = (isset($row['foto']) && trim($row['foto']) != '') ? $row['foto'] : 'users.gif';
            @endphp
            
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 p-6 flex items-start space-x-4">
                <img src="{{ url('asset/foto_user/' . $foto) }}" alt="{{ $row['nama_lengkap'] ?? '' }}" class="w-16 h-16 rounded-full object-cover border-2 border-green-100">
                
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg font-bold text-gray-900 capitalize truncate" style="color: #e53e3e;">
                        {{ $row['nama_lengkap'] ?? 'Tanpa Nama' }}
                    </h3>
                    <p class="text-sm text-gray-600 font-medium truncate mt-1">
                        <i class="fa-solid fa-briefcase text-gray-400 w-4"></i> 
                        {{ $row['perangkat_daerah'] ?? '-' }}
                    </p>
                    <p class="text-xs text-gray-500 truncate mt-1">
                        <i class="fa-solid fa-envelope text-gray-400 w-4"></i> 
                        {{ $row['email'] ?? '-' }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
    
    @if(count($psikolog) == 0)
        <div class="bg-gray-50 rounded-xl p-8 text-center border border-gray-100">
            <i class="fa-solid fa-user-doctor text-4xl text-gray-300 mb-3"></i>
            <p class="text-gray-500">Belum ada data psikolog.</p>
        </div>
    @endif

    <div class="mt-8 flex justify-center">
        {{ $psikolog->links() ?? '' }}
    </div>
</div>
@endsection

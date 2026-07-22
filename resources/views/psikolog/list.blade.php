@extends('layouts.app')
@section('content')
<div class="max-w-6xl mx-auto mb-12">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <span class="text-gray-800 font-medium">{{ $title }}</span>
    </div>

    <h2 class="text-3xl font-bold text-gray-900 mb-8 pb-3 border-b-2 border-green-600 inline-block">{{ $title }}</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
        @foreach ($psikolog as $index => $row)
            @php
                $foto = empty(trim($row->foto)) ? "users.gif" : $row->foto;
            @endphp
            <div class="bg-white rounded-xl p-5 shadow-sm hover:shadow-md transition-shadow border border-gray-100 flex items-start space-x-4">
                <img class="w-16 h-16 rounded-full object-cover border-2 border-gray-100 shadow-sm flex-shrink-0" src="{{ url('asset/foto_user/'.$foto) }}" alt="{{ $row->nama_lengkap }}">
                <div class="flex-1 overflow-hidden">
                    <h3 class="font-bold text-gray-900 text-lg truncate capitalize mb-1 hover:text-green-600 transition-colors">{{ $row->nama_lengkap }}</h3>
                    <p class="text-sm text-gray-600 mb-1.5 line-clamp-2"><i class="fa-solid fa-briefcase text-green-500 mr-1.5 w-4 text-center"></i>{{ $row->perangkat_daerah ?? '-' }}</p>
                    <p class="text-xs text-gray-500 truncate"><i class="fa-solid fa-envelope text-green-500 mr-1.5 w-4 text-center"></i>{{ $row->email }}</p>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-10">
        {{ $psikolog->links('pagination::tailwind') }}	
    </div>
</div>
@endsection

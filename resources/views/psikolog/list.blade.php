@extends('layouts.app')
@section('content')
<div class="max-w-6xl mx-auto mb-12">
    <!-- Breadcrumb -->
    <div class="text-xs text-slate-500 mb-6 flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-emerald-600 transition-colors"><i class="fa-solid fa-house text-emerald-600 mr-1"></i> Home</a> 
        <span><i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i></span> 
        <span class="text-slate-800 font-semibold">{{ $title }}</span>
    </div>

    <div class="mb-8 pb-4 border-b border-slate-200 flex items-center justify-between">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200/60 inline-block mb-2">Tim Profesional</span>
            <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $title }}</h2>
        </div>
        <span class="text-xs font-medium text-slate-500 bg-white px-3.5 py-1.5 rounded-full border border-slate-200 shadow-sm hidden sm:inline-block">
            <i class="fa-solid fa-user-doctor text-emerald-600 mr-1.5"></i> Berlisensi & Empatis
        </span>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-4">
        @foreach ($psikolog as $index => $row)
            @php
                $foto = empty(trim($row->foto)) ? "users.gif" : $row->foto;
            @endphp
            <div class="bg-white rounded-2xl p-5 shadow-sm hover:shadow-xl hover:shadow-emerald-950/5 transition-all duration-300 border border-slate-200/80 flex items-start space-x-4 group hover:-translate-y-1">
                <div class="relative flex-shrink-0">
                    <img class="w-16 h-16 rounded-full object-cover border-2 border-emerald-100 shadow-md group-hover:scale-105 transition-transform" src="{{ url('asset/foto_user/'.$foto) }}" alt="{{ $row->nama_lengkap }}">
                    <span class="absolute bottom-0 right-0 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></span>
                </div>
                <div class="flex-1 overflow-hidden">
                    <h3 class="font-bold text-slate-900 text-base truncate capitalize mb-1 group-hover:text-emerald-600 transition-colors">{{ $row->nama_lengkap }}</h3>
                    <p class="text-xs text-slate-600 mb-2 line-clamp-1 flex items-center"><i class="fa-solid fa-building-user text-emerald-600 mr-1.5 w-4 text-center"></i>{{ $row->perangkat_daerah ?? '-' }}</p>
                    <p class="text-[11px] text-slate-500 truncate flex items-center"><i class="fa-regular fa-envelope text-emerald-600 mr-1.5 w-4 text-center"></i>{{ $row->email }}</p>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-10">
        {{ $psikolog->links('pagination::tailwind') }}	
    </div>
</div>
@endsection


@extends('layouts.app')
@section('content')
@php
	$baca = $rows->dibaca + 1;	
@endphp	
<div class="max-w-4xl mx-auto mb-12">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 flex flex-wrap items-center gap-2">
        <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <a href="#" class="hover:text-green-600 transition-colors" rel="category tag">{{ $rows->nama_kategori ?? 'Halaman' }}</a> 
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <span class="text-gray-800 font-medium">{{ $rows->judul }}</span>
    </div>  
    
    <header class="mb-8 border-b border-gray-200 pb-6">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-4">
            {{ $rows->judul }}
        </h1>
        
        <div class="flex flex-wrap items-center text-sm text-gray-500 gap-4 uppercase font-medium">
            <span class="flex items-center"><i class="fa-regular fa-calendar text-green-500 mr-2"></i> {{ $rows->hari.', '.tgl_indo($rows->tgl_posting)." | ".$rows->jam." WIB" }}</span>
        </div>
    </header>
  
    @if ($rows->gambar != '')
    <div class="mb-8 bg-gray-50 rounded-xl overflow-hidden shadow-sm border border-gray-100 flex justify-center">
        <img class="w-full max-h-[500px] object-contain" src="{{ url('asset/foto_statis/'.$rows->gambar) }}" alt="{{ $rows->judul }}" />
    </div>
    @endif
  
    <article class="prose max-w-none prose-green prose-lg text-gray-800 leading-relaxed mb-10">
        {!! $rows->isi_halaman !!}
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class='fb-like' data-href="{{ url('halaman/detail/'.$rows->judul_seo) }}" data-send='false' data-width='600' data-show-faces='false'></div>
        </div>
    </article>
</div>
@endsection

@extends('layouts.app')
@section('content')
<div class="mb-8 max-w-4xl mx-auto">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <span>Pencarian</span>
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <span class="text-gray-800 font-medium">{{ $title }}</span>
    </div>  
    
    <h2 class="text-3xl font-bold text-gray-900 mb-8 pb-3 border-b-2 border-green-600 inline-block">{{ $title }}</h2>
    
    <div class="space-y-8">
        @foreach ($berita as $pi)
        <?php 
            $total_komentar = \Illuminate\Support\Facades\DB::table('komentar')->where('id_berita', $pi->id_berita)->where('aktif', 'Y')->count();
            $tgl = tgl_indo($pi->tanggal);
            $isi_berita = strip_tags($pi->isi_berita); 
            $isi = substr($isi_berita, 0, 500); 
            $isi = substr($isi, 0, strrpos($isi, " ")); 
        ?>
            <article class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 p-6">
                <h4 class="text-2xl font-bold text-gray-900 mb-3 hover:text-green-600 transition-colors">
                    <a href='{{ url('berita/detail/'.$pi->judul_seo) }}' title='{{ $pi->judul }}'>{{ $pi->judul }}</a>
                </h4>
                
                <div class="flex flex-wrap items-center text-xs text-gray-500 mb-4 gap-y-2">
                    <div class="flex items-center mr-4">
                        <i class="fa-regular fa-clock text-green-500 mr-1.5"></i> {{ $pi->jam }}, {{ $tgl }} ({{ cek_terakhir($pi->tanggal.' '.$pi->jam) }} Lalu)
                    </div>
                    <div class="flex items-center mr-4">
                        <i class="fa-regular fa-comments text-green-500 mr-1.5"></i> {{ $total_komentar }} Komentar
                    </div>
                    <div class="flex items-center text-red-500 font-medium ml-auto">
                        <i class="fa-solid fa-eye mr-1.5"></i> {{ $pi->dibaca }} View
                    </div>
                </div>
                
                <p class="text-gray-600 leading-relaxed mb-4">
                    {{ $isi }}...
                </p>
                
                <a href='{{ url('berita/detail/'.$pi->judul_seo) }}' class="inline-flex items-center text-sm font-semibold text-green-600 hover:text-green-800 transition-colors group">
                    Baca selengkapnya <i class="fa-solid fa-arrow-right ml-1.5 text-xs transition-transform group-hover:translate-x-1"></i>
                </a>
            </article>
        @endforeach
    </div>	
    
    <div class="mt-10">
        {{ $berita->links('pagination::tailwind') }}	
    </div>
</div>
@endsection

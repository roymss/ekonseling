@extends('layouts.app')
@section('content')
<div class="mb-8">
    <div class="border-b-2 border-green-600 mb-6 pb-2 inline-block">
        <h4 class="text-xl font-bold text-gray-800 uppercase tracking-wide"><i class="fa-solid fa-newspaper text-green-600 mr-2"></i> BERITA TERKINI</h4>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach ($terkini as $row)
        <?php 
            $total_komentar = \Illuminate\Support\Facades\DB::table('komentar')->where('id_berita', $row->id_berita)->count();
            $tgl = tgl_indo($row->tanggal);
            $isi_berita = strip_tags($row->isi_berita); 
            $isi = substr($isi_berita,0,255); 
            $isi = substr($isi_berita,0,strrpos($isi," ")); 
        ?>
            <article class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow border border-gray-100 overflow-hidden flex flex-col h-full group">
                <div class="relative h-56 overflow-hidden">
                    @if ($row->gambar =='')
                        <a href='{{ url('berita/detail/'.$row->judul_seo) }}'>
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src='{{ url('asset/foto_berita/no-image.jpg') }}' alt='{{ $row->judul }}' />
                        </a>
                    @else
                        <a href='{{ url('berita/detail/'.$row->judul_seo) }}'>
                            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src='{{ url('asset/foto_berita/'.$row->gambar) }}' alt='{{ $row->judul }}' />
                        </a>
                    @endif
                    <div class="absolute top-4 left-4 bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                        Baru
                    </div>
                </div>
                
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex items-center text-xs text-gray-500 mb-3 space-x-4">
                        <span><i class="fa-regular fa-calendar mr-1 text-green-500"></i> {{ $row->hari }}, {{ $tgl }}</span>
                        <span><i class="fa-regular fa-clock mr-1 text-green-500"></i> {{ $row->jam }}</span>
                        <span><i class="fa-regular fa-comments mr-1 text-green-500"></i> {{ $total_komentar }}</span>
                    </div>
                    
                    <h4 class="text-lg font-bold text-gray-900 mb-3 line-clamp-2 hover:text-green-600 transition-colors">
                        <a href='{{ url('berita/detail/'.$row->judul_seo) }}' title='{{ $row->judul }}'>{{ $row->judul }}</a>
                    </h4>
                    
                    <p class="text-gray-600 text-sm mb-4 line-clamp-3 leading-relaxed flex-grow">
                        {{ $isi }}...
                    </p>
                    
                    <div class="mt-auto pt-4 border-t border-gray-50">
                        <a class="text-green-600 hover:text-green-800 font-semibold text-sm flex items-center transition-colors group-hover:underline" href='{{ url('berita/detail/'.$row->judul_seo) }}'>
                            Baca selengkapnya <i class="fa-solid fa-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </article>
        @endforeach                 
    </div>
</div>
@endsection

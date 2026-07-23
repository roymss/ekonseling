@extends('layouts.app')
@section('content')
<div class="mb-12 max-w-5xl mx-auto">
    <!-- Breadcrumb -->
    <div class="text-xs text-slate-500 mb-6 flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-emerald-600 transition-colors"><i class="fa-solid fa-house text-emerald-600 mr-1"></i> Home</a> 
        <span><i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i></span> 
        <span>Berita</span>
        <span><i class="fa-solid fa-angle-right text-[10px] text-slate-400"></i></span> 
        <span class="text-slate-800 font-semibold">{{ $title }}</span>
    </div>  
    
    <div class="mb-8 pb-4 border-b border-slate-200">
        <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200/60 inline-block mb-2">Arsip & Hasil</span>
        <h2 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">{{ $title }}</h2>
    </div>
    
    <div class="space-y-6">
        @foreach ($berita as $pi)
        <?php 
            $total_komentar = \Illuminate\Support\Facades\DB::table('komentar')->where('id_berita', $pi->id_berita)->where('aktif', 'Y')->count();
            $tgl = tgl_indo($pi->tanggal);
            $isi_berita = strip_tags($pi->isi_berita); 
            $isi = substr($isi_berita, 0, 300); 
            $isi = substr($isi, 0, strrpos($isi, " ")); 

            $dummyImages = [
                'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1527689368864-3a821dbccc34?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1506126613408-eca07ce68773?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1544027993-37dbfe43562a?q=80&w=800&auto=format&fit=crop'
            ];
            $imgIndex = isset($pi->id_berita) ? ($pi->id_berita % count($dummyImages)) : 0;
            $foto_berita = (!empty($pi->gambar) && file_exists(public_path('asset/foto_berita/'.$pi->gambar))) 
                ? url('asset/foto_berita/'.$pi->gambar) 
                : $dummyImages[$imgIndex];
        ?>
            <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl hover:shadow-emerald-950/5 transition-all duration-300 border border-slate-200/80 p-5 md:p-6 flex flex-col md:flex-row gap-6 items-start group hover:-translate-y-0.5">
                <div class="w-full md:w-56 h-44 rounded-xl overflow-hidden bg-slate-100 flex-shrink-0 relative">
                    <a href='{{ url('berita/detail/'.$pi->judul_seo) }}' class="block w-full h-full">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $foto_berita }}" alt="{{ $pi->judul }}">
                    </a>
                </div>

                <div class="flex-1 flex flex-col justify-between h-full space-y-3 w-full">
                    <div>
                        <div class="flex flex-wrap items-center text-xs text-slate-500 mb-2 gap-3">
                            <span class="inline-flex items-center"><i class="fa-regular fa-clock text-emerald-600 mr-1.5"></i> {{ $pi->jam }}, {{ $tgl }}</span>
                            <span class="inline-flex items-center"><i class="fa-regular fa-comments text-emerald-600 mr-1.5"></i> {{ $total_komentar }} Komentar</span>
                            <span class="inline-flex items-center text-slate-400 ml-auto"><i class="fa-solid fa-eye text-emerald-600 mr-1.5"></i> {{ $pi->dibaca }} views</span>
                        </div>

                        <h3 class="text-lg md:text-xl font-bold text-slate-900 leading-snug group-hover:text-emerald-600 transition-colors mb-2">
                            <a href='{{ url('berita/detail/'.$pi->judul_seo) }}' title='{{ $pi->judul }}'>{{ $pi->judul }}</a>
                        </h3>
                        
                        <p class="text-slate-600 text-sm leading-relaxed line-clamp-2">
                            {{ $isi }}...
                        </p>
                    </div>

                    <div class="pt-2 border-t border-slate-100">
                        <a href='{{ url('berita/detail/'.$pi->judul_seo) }}' class="inline-flex items-center text-xs font-bold text-emerald-600 hover:text-emerald-800 transition-colors group-hover:translate-x-0.5">
                            <span>Baca Selengkapnya</span>
                            <i class="fa-solid fa-arrow-right ml-1.5 text-[10px] transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </article>
        @endforeach
    </div>	
    
    <div class="mt-10">
        {{ $berita->links('pagination::tailwind') }}	
    </div>
</div>
@endsection


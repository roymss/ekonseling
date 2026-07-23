@extends('layouts.app')
@section('content')

<!-- Hero Banner Section -->
<div class="relative bg-gradient-to-br from-emerald-900 via-teal-900 to-slate-900 text-white rounded-3xl p-8 md:p-12 mb-12 shadow-2xl shadow-emerald-950/20 overflow-hidden border border-emerald-800/40">
    <!-- Decorative Ambient Glows -->
    <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -left-24 w-80 h-80 bg-teal-400/20 rounded-full blur-3xl pointer-events-none"></div>

    <div class="relative z-10 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
        <div class="lg:col-span-8 space-y-6">
            <div class="inline-flex items-center space-x-2 bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 px-3.5 py-1.5 rounded-full text-xs font-semibold tracking-wide backdrop-blur-md">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span>Layanan Konseling Online Resmi</span>
            </div>

            <h1 class="text-3xl md:text-5xl font-extrabold text-white tracking-tight leading-tight">
                Ruang Aman untuk Kesehatan Mental & Konseling Anda
            </h1>

            <p class="text-slate-300 text-sm md:text-base leading-relaxed max-w-2xl font-normal">
                Dapatkan bimbingan dan konsultasi profesional dari para psikolog terpercaya. Privasi & kerahasiaan Anda terjaga 100% secara aman dan nyaman.
            </p>

            <div class="flex flex-wrap items-center gap-4 pt-2">
                <a href="{{ url('user/konsultasi_tambah') }}" class="inline-flex items-center justify-center space-x-2 bg-gradient-to-r from-emerald-400 to-teal-400 hover:from-emerald-300 hover:to-teal-300 text-slate-950 font-bold px-6 py-3 rounded-2xl shadow-xl shadow-emerald-500/20 hover:shadow-emerald-500/30 hover:-translate-y-0.5 transition-all text-sm">
                    <i class="fa-solid fa-paper-plane text-slate-950"></i>
                    <span>Konsultasi Sekarang</span>
                </a>
                
                <a href="{{ url('psikolog/lists') }}" class="inline-flex items-center justify-center space-x-2 bg-white/10 hover:bg-white/20 text-white font-semibold px-6 py-3 rounded-2xl border border-white/20 backdrop-blur-md transition-all text-sm">
                    <i class="fa-solid fa-user-doctor text-emerald-300"></i>
                    <span>Lihat Psikolog Kami</span>
                </a>
            </div>
        </div>

        <!-- Quick Stats / Feature Cards -->
        <div class="lg:col-span-4 space-y-3">
            <div class="bg-white/10 backdrop-blur-md border border-white/10 p-4 rounded-2xl flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-500/20 flex items-center justify-center text-emerald-300 text-xl font-bold flex-shrink-0">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h4 class="font-bold text-white text-sm">100% Kerahasiaan Terjamin</h4>
                    <p class="text-xs text-slate-300">Sesi konseling aman & privat</p>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md border border-white/10 p-4 rounded-2xl flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-teal-500/20 flex items-center justify-center text-teal-300 text-xl font-bold flex-shrink-0">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div>
                    <h4 class="font-bold text-white text-sm">Psikolog Profesional</h4>
                    <p class="text-xs text-slate-300">Tenaga ahli berlisensi</p>
                </div>
            </div>

            <div class="bg-white/10 backdrop-blur-md border border-white/10 p-4 rounded-2xl flex items-center space-x-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-400/20 flex items-center justify-center text-emerald-200 text-xl font-bold flex-shrink-0">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div>
                    <h4 class="font-bold text-white text-sm">Akses Kapan Saja</h4>
                    <p class="text-xs text-slate-300">Layanan mudah & cepat</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Content Grid -->
<div class="mb-12">
    <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-200">
        <div>
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full border border-emerald-200/60 inline-block mb-2">Informasi & Artikel</span>
            <h3 class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight flex items-center">
                <i class="fa-solid fa-newspaper text-emerald-600 mr-3 text-xl"></i> Berita Terkini
            </h3>
        </div>
        <a href="{{ url('berita') }}" class="text-xs font-bold text-emerald-600 hover:text-emerald-700 bg-emerald-50 hover:bg-emerald-100 px-4 py-2 rounded-xl transition-all flex items-center space-x-1">
            <span>Lihat Semua Berita</span>
            <i class="fa-solid fa-chevron-right text-[10px]"></i>
        </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        @foreach ($terkini as $row)
        <?php 
            $total_komentar = \Illuminate\Support\Facades\DB::table('komentar')->where('id_berita', $row->id_berita)->count();
            $tgl = tgl_indo($row->tanggal);
            $isi_berita = strip_tags($row->isi_berita); 
            $isi = substr($isi_berita,0,220); 
            $isi = substr($isi_berita,0,strrpos($isi," ")); 

            $dummyImages = [
                'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1527689368864-3a821dbccc34?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1516589178581-6cd7833ae3b2?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1506126613408-eca07ce68773?q=80&w=800&auto=format&fit=crop',
                'https://images.unsplash.com/photo-1544027993-37dbfe43562a?q=80&w=800&auto=format&fit=crop'
            ];
            $imgIndex = isset($row->id_berita) ? ($row->id_berita % count($dummyImages)) : 0;
            $foto_berita = (!empty($row->gambar) && file_exists(public_path('asset/foto_berita/'.$row->gambar))) 
                ? url('asset/foto_berita/'.$row->gambar) 
                : $dummyImages[$imgIndex];
        ?>
            <article class="bg-white rounded-2xl shadow-sm hover:shadow-xl hover:shadow-emerald-900/5 transition-all duration-300 border border-slate-200/80 overflow-hidden flex flex-col h-full group hover:-translate-y-1">
                <div class="relative h-60 overflow-hidden bg-slate-100">
                    <a href='{{ url('berita/detail/'.$row->judul_seo) }}' class="block w-full h-full">
                        <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src='{{ $foto_berita }}' alt='{{ $row->judul }}' />
                    </a>
                    <div class="absolute top-4 left-4 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-[11px] font-bold px-3 py-1 rounded-full shadow-md backdrop-blur-sm">
                        Terbaru
                    </div>
                </div>
                
                <div class="p-6 flex flex-col flex-grow">
                    <div class="flex flex-wrap items-center text-xs text-slate-500 mb-3 gap-3">
                        <span class="inline-flex items-center"><i class="fa-regular fa-calendar-days mr-1.5 text-emerald-600"></i> {{ $row->hari }}, {{ $tgl }}</span>
                        <span class="inline-flex items-center"><i class="fa-regular fa-clock mr-1.5 text-emerald-600"></i> {{ $row->jam }}</span>
                        <span class="inline-flex items-center"><i class="fa-regular fa-comments mr-1.5 text-emerald-600"></i> {{ $total_komentar }} Komentar</span>
                    </div>
                    
                    <h4 class="text-lg font-bold text-slate-900 mb-3 line-clamp-2 leading-snug group-hover:text-emerald-600 transition-colors">
                        <a href='{{ url('berita/detail/'.$row->judul_seo) }}' title='{{ $row->judul }}'>{{ $row->judul }}</a>
                    </h4>
                    
                    <p class="text-slate-600 text-sm mb-6 line-clamp-3 leading-relaxed flex-grow">
                        {{ $isi }}...
                    </p>
                    
                    <div class="mt-auto pt-4 border-t border-slate-100 flex items-center justify-between">
                        <a class="text-emerald-600 hover:text-emerald-800 font-bold text-sm flex items-center transition-colors group-hover:translate-x-0.5" href='{{ url('berita/detail/'.$row->judul_seo) }}'>
                            <span>Baca Selengkapnya</span>
                            <i class="fa-solid fa-arrow-right ml-2 text-xs transition-transform group-hover:translate-x-1"></i>
                        </a>
                    </div>
                </div>
            </article>
        @endforeach                 
    </div>
</div>
@endsection


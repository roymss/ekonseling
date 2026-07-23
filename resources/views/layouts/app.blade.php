<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>  
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title ?? 'E-Konseling' }}</title>
    <meta name="description" content="{{ $description ?? '' }}">
    <meta name="keywords" content="{{ $keywords ?? '' }}">
    <meta name="author" content="phpmu.com">
    <meta name="robots" content="index, follow">
    
    <link rel="canonical" href="{{ url()->current() }}"/>
    @if (request()->segment(1) == 'berita' && request()->segment(2) == 'detail')
        @php 
            $rows = \Illuminate\Support\Facades\DB::table('berita')->where('judul_seo', request()->segment(3))->first(); 
        @endphp
        @if ($rows)
        <meta property="og:title" content="{{ $title }}" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="{{ url('berita/detail/'.request()->segment(3)) }}" />
        <meta property="og:image" content="{{ url('asset/foto_berita/'.$rows->gambar) }}" />
        <meta property="og:description" content="{{ $description }}"/>
        @endif
    @endif
    
    <link rel="shortcut icon" href="{{ url('/') }}/asset/images/{{ favicon() ?? 'favicon.ico' }}" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="{{ url('rss.xml') }}" />
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AlpineJS for Interactive UI elements -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>

    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
</head>
 
<body class="bg-slate-50/70 text-slate-800 font-sans leading-normal tracking-normal flex flex-col min-h-screen selection:bg-emerald-500 selection:text-white">

    <!-- Top Bar -->
    <div class="bg-gradient-to-r from-emerald-900 via-teal-800 to-emerald-950 text-white shadow-sm z-50">
        @include('partials.header-top')
    </div>

    <!-- Main Header -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-md shadow-sm border-b border-emerald-100/60 transition-all duration-300">  
        @include('partials.header')
    </header> 

    <!-- Main Content -->
    <main class="flex-grow relative">
        <!-- Ambient background soft glow circles -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-emerald-300/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/3 right-10 w-96 h-96 bg-teal-300/10 rounded-full blur-3xl pointer-events-none"></div>
        
        <div class="container mx-auto px-4 py-8 relative z-10">
            @yield('content') 
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-100 py-12 border-t border-slate-800">
        @if (request()->segment(1) != 'user')
            @include('partials.footer')
        @endif
    </footer> 

    <!-- Copyright -->
    <div class="bg-slate-950 text-center py-4 text-slate-400 text-sm border-t border-slate-900">
        <div class="container mx-auto px-4 flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
            <p>&copy; {{ date('Y') }} <span class="font-bold text-emerald-400">E-Konseling</span>. Layanan Konseling Online Terpercaya.</p>
            <p class="text-xs text-slate-500">Integritas & Kerahasiaan Terjamin</p>
        </div>
    </div>

    <!-- Upload Modal (AlpineJS version) -->
    <div x-data="{ uploadModalOpen: false }" @open-upload-modal.window="uploadModalOpen = true">
        <div x-show="uploadModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="uploadModalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" @click="uploadModalOpen = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="uploadModalOpen" x-transition class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-slate-100">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-xl font-bold text-slate-900" id="modal-title">Ganti Foto Profil Anda</h3>
                                <div class="mt-4">
                                    <form method="POST" action="{{ url('user/foto') }}" enctype="multipart/form-data" class="space-y-4">
                                        @csrf
                                        <p class="text-xs text-slate-500 bg-slate-50 p-2.5 rounded-lg border border-slate-200"><i class="fa-solid fa-circle-info text-emerald-500 mr-1"></i> Ukuran disarankan maks 200 KB atau 600 x 600 px</p>
                                        
                                        <div>
                                            <label class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-2">Pilih File Foto</label>
                                            <div class="mt-1 flex rounded-xl shadow-sm border border-slate-200 overflow-hidden focus-within:ring-2 focus-within:ring-emerald-500">
                                                <span class="inline-flex items-center px-3 bg-slate-100 text-slate-500 sm:text-sm border-r border-slate-200">
                                                    <i class="fa fa-image"></i>
                                                </span>
                                                <input type="file" name="f" class="flex-1 min-w-0 block w-full px-3 py-2 text-sm text-slate-700 bg-white focus:outline-none">
                                            </div>
                                        </div>
                                        <div class="mt-6 sm:flex sm:flex-row-reverse gap-3">
                                            <button type="submit" name="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-md px-5 py-2.5 bg-emerald-600 text-sm font-semibold text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:w-auto transition-all">
                                                Update Foto
                                            </button>
                                            <button type="button" @click="uploadModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-200 shadow-sm px-5 py-2.5 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 focus:outline-none sm:mt-0 sm:w-auto transition-all">
                                                Batal
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to top button -->
    <button x-data="{ show: false }" @scroll.window="show = window.pageYOffset > 100" @click="window.scrollTo({top: 0, behavior: 'smooth'})" x-show="show" x-transition class="fixed bottom-8 right-8 bg-emerald-600 text-white rounded-full w-12 h-12 flex items-center justify-center shadow-lg shadow-emerald-600/30 hover:bg-emerald-700 hover:scale-110 focus:outline-none transition-all duration-300 z-50 group">
        <i class="fa-solid fa-arrow-up text-base group-hover:-translate-y-0.5 transition-transform"></i>
    </button>
</body>
</html>

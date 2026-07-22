<!DOCTYPE html>
<html lang="id">
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
    
    <!-- Vite Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AlpineJS for Interactive UI elements -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.0";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
    </script>
</head>
 
<body class="bg-gray-50 font-sans leading-normal tracking-normal flex flex-col min-h-screen">

    <!-- Top Bar -->
    <div class="bg-green-800 text-white shadow-md z-50">
        @include('partials.header-top')
    </div>

    <!-- Main Header -->
    <header class="sticky top-0 z-40 bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-100 transition-all duration-300">  
        @include('partials.header')
    </header> 

    <!-- Main Content -->
    <main class="flex-grow">
        <div class="container mx-auto px-4 py-8">
            @yield('content') 
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-10">
        @if (request()->segment(1) != 'user')
            @include('partials.footer')
        @endif
    </footer> 

    <!-- Copyright -->
    <div class="bg-gray-950 text-center py-4 text-gray-400 text-sm">
        <div class="container mx-auto px-4">
            <p>&copy; {{ date('Y') }} E-Konseling. All rights reserved.</p>
        </div>
    </div>

    <!-- Upload Modal (AlpineJS version) -->
    <div x-data="{ uploadModalOpen: false }" @open-upload-modal.window="uploadModalOpen = true">
        <div x-show="uploadModalOpen" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="uploadModalOpen" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="uploadModalOpen = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div x-show="uploadModalOpen" x-transition class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Ganti Foto Profile anda?</h3>
                                <div class="mt-4">
                                    <form method="POST" action="{{ url('user/foto') }}" enctype="multipart/form-data" class="space-y-4">
                                        @csrf
                                        <p class="text-sm text-gray-500 text-center">Recommended (200 Kb atau 600 x 600)</p>
                                        
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Pilih Foto</label>
                                            <div class="mt-1 flex rounded-md shadow-sm">
                                                <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">
                                                    <i class="fa fa-image"></i>
                                                </span>
                                                <input type="file" name="f" class="flex-1 min-w-0 block w-full px-3 py-2 rounded-none rounded-r-md border border-gray-300 focus:ring-green-500 focus:border-green-500 sm:text-sm">
                                            </div>
                                        </div>
                                        <div class="mt-5 sm:mt-4 sm:flex sm:flex-row-reverse">
                                            <button type="submit" name="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                                Update Foto
                                            </button>
                                            <button type="button" @click="uploadModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:mt-0 sm:w-auto sm:text-sm">
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
    <button x-data="{ show: false }" @scroll.window="show = window.pageYOffset > 50" @click="window.scrollTo({top: 0, behavior: 'smooth'})" x-show="show" x-transition class="fixed bottom-8 right-8 bg-green-600 text-white rounded-full p-3 shadow-lg hover:bg-green-700 focus:outline-none z-50">
        <i class="fa-solid fa-arrow-up"></i>
    </button>
</body>
</html>

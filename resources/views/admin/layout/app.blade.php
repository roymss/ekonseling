<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard - E-Konseling')</title>

    <!-- Vite Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AlpineJS for Interactive UI elements -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal overflow-hidden" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen bg-gray-100">
        
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-900 transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 flex flex-col shadow-xl">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-center h-16 bg-gray-900 border-b border-gray-800">
                <span class="text-white text-xl font-bold uppercase tracking-wider">
                    <i class="fa-solid fa-leaf text-blue-500 mr-2"></i>E-Konseling
                </span>
            </div>
            
            <!-- User Info -->
            <div class="flex items-center justify-center py-6 border-b border-gray-800">
                <div class="text-center">
                    <div class="relative inline-block">
                        <img class="h-16 w-16 rounded-full border-2 border-blue-500 object-cover" src="{{ url('asset/foto_user/blank.png') }}" alt="User profile">
                        <span class="absolute bottom-0 right-0 block h-4 w-4 rounded-full bg-green-500 border-2 border-gray-900"></span>
                    </div>
                    <p class="mt-2 text-sm font-semibold text-white uppercase">{{ session('username') }}</p>
                    <p class="text-xs text-gray-400 capitalize">{{ session('level') }}</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="flex-1 px-4 py-4 space-y-2 overflow-y-auto custom-scrollbar">
                
                <p class="px-2 text-xs font-semibold text-gray-500 uppercase tracking-wider mb-2">Menu Utama</p>
                <a href="{{ url('admin/home') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors group">
                    <i class="fa-solid fa-gauge-high w-5 text-gray-400 group-hover:text-blue-500"></i>
                    <span class="ml-3">Dashboard</span>
                </a>

                <!-- Modul Berita -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors group">
                        <div class="flex items-center">
                            <i class="fa-solid fa-newspaper w-5 text-gray-400 group-hover:text-blue-500"></i>
                            <span class="ml-3">Modul Berita</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse class="pl-11 pr-2 py-1 space-y-1">
                        <a href="{{ url('admin/listberita') }}" class="block px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md">Daftar Berita</a>
                        <a href="{{ url('admin/kategoriberita') }}" class="block px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md">Kategori</a>
                        <a href="{{ url('admin/komentarberita') }}" class="block px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md">Komentar</a>
                    </div>
                </div>

                <!-- Modul Konsultasi -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors group">
                        <div class="flex items-center">
                            <i class="fa-solid fa-stethoscope w-5 text-gray-400 group-hover:text-blue-500"></i>
                            <span class="ml-3">Konsultasi</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse class="pl-11 pr-2 py-1 space-y-1">
                        <a href="{{ url('admin/konsul') }}" class="block px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md">Data Konsultasi</a>
                        <a href="{{ url('admin/kategori_konsul') }}" class="block px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md">Kategori Konsul</a>
                        <a href="{{ url('admin/komentar_konsul') }}" class="block px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md">Komentar</a>
                    </div>
                </div>

                <!-- Modul Website -->
                <div x-data="{ open: false }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-4 py-2.5 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors group">
                        <div class="flex items-center">
                            <i class="fa-solid fa-globe w-5 text-gray-400 group-hover:text-blue-500"></i>
                            <span class="ml-3">Modul Web</span>
                        </div>
                        <i class="fa-solid fa-chevron-down text-xs transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                    </button>
                    <div x-show="open" x-collapse class="pl-11 pr-2 py-1 space-y-1">
                        <a href="{{ url('admin/identitaswebsite') }}" class="block px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md">Identitas</a>
                        <a href="{{ url('admin/menuwebsite') }}" class="block px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md">Menu Utama</a>
                        <a href="{{ url('admin/halamanbaru') }}" class="block px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-gray-800 rounded-md">Halaman Baru</a>
                    </div>
                </div>
                
                <a href="{{ url('admin/manajemenuser') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors group">
                    <i class="fa-solid fa-users w-5 text-gray-400 group-hover:text-blue-500"></i>
                    <span class="ml-3">Manajemen User</span>
                </a>

                <a href="{{ url('admin/manajemen_psikolog') }}" class="flex items-center px-4 py-2.5 text-sm font-medium text-gray-300 hover:text-white hover:bg-gray-800 rounded-lg transition-colors group">
                    <i class="fa-solid fa-user-md w-5 text-gray-400 group-hover:text-green-500"></i>
                    <span class="ml-3">Manajemen Psikolog</span>
                </a>

            </nav>

            <div class="p-4 border-t border-gray-800">
                <a href="{{ url('admin/logout') }}" class="flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                    <i class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden relative">
            
            <!-- Top Header -->
            <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200">
                <div class="flex items-center">
                    <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 hover:text-gray-700 focus:outline-none lg:hidden">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h1 class="ml-4 text-xl font-semibold text-gray-800 hidden sm:block">@yield('page_title', 'Dashboard')</h1>
                </div>

                <div class="flex items-center space-x-4">
                    <button class="text-gray-500 hover:text-gray-700 relative">
                        <i class="fa-regular fa-bell text-xl"></i>
                        <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
                    </button>
                    <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold uppercase">
                        {{ substr(session('username'), 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                @yield('content')
            </main>
            
        </div>
    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 5px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #374151;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #4B5563;
        }
    </style>
</body>
</html>

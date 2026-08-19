<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>  
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Dashboard - E-Konseling')</title>
    
    <link rel="icon" type="image/svg+xml" href="{{ url('favicon.svg') }}?v=2" />
    
    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Vite Tailwind CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AlpineJS -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
 
<body class="bg-white text-slate-800 font-sans leading-normal tracking-normal flex flex-col min-h-screen selection:bg-[#002045] selection:text-white">

    <!-- Main Header -->
    <header class="sticky top-0 z-40 bg-[#F9F9FF] transition-all duration-300">  
        @include('partials.header')
    </header> 

    <!-- Main Content -->
    <main class="flex-grow relative bg-[#F9F9FF] font-['Inter']">
        <div class="max-w-[1280px] mx-auto py-8 md:py-12 px-4 md:px-10 flex flex-col md:flex-row gap-6 items-start">
            
            <!-- Aside - Local Sidebar Navigation -->
            <aside class="w-full md:w-[256px] flex-shrink-0 bg-white border border-[#C4C6CF] rounded-lg p-3 flex flex-col gap-1 shadow-sm">
                
                <div class="flex items-center justify-center py-4 border-b border-[#C4C6CF] mb-2 flex-col">
                    <img class="h-16 w-16 rounded-full border-2 border-blue-500 object-cover" src="{{ url('asset/foto_user/blank.png') }}" alt="User profile">
                    <p class="mt-2 text-sm font-semibold text-[#002045] uppercase">{{ session('username') }}</p>
                    <p class="text-xs text-slate-500 capitalize">{{ session('level') }}</p>
                </div>

                <div class="px-3 py-2">
                    <span class="text-[#43474E] text-[12px] font-medium leading-4">Menu Admin</span>
                </div>
                
                <a href="{{ url('admin/dashboard') }}" class="w-full rounded p-3 flex items-center justify-between transition-colors {{ request()->is('admin/home') || request()->is('admin/dashboard') ? 'bg-[#D8E3FA] text-[#002045]' : 'hover:bg-slate-50 text-[#43474E]' }}">
                    <span class="text-[14px] leading-5 {{ request()->is('admin/home') || request()->is('admin/dashboard') ? 'font-semibold text-[#002045]' : 'font-medium text-[#43474E]' }}">Dashboard</span>
                    <i class="fa-solid fa-gauge-high {{ request()->is('admin/home') || request()->is('admin/dashboard') ? 'text-[#002045]' : 'text-[#43474E]' }}"></i>
                </a>



                <a href="{{ url('admin/manajemenuser') }}" class="w-full rounded p-3 flex items-center justify-between transition-colors {{ request()->is('admin/manajemenuser') ? 'bg-[#D8E3FA] text-[#002045]' : 'hover:bg-slate-50 text-[#43474E]' }}">
                    <span class="text-[14px] leading-5 {{ request()->is('admin/manajemenuser') ? 'font-semibold text-[#002045]' : 'font-medium text-[#43474E]' }}">Manajemen User</span>
                    <i class="fa-solid fa-users {{ request()->is('admin/manajemenuser') ? 'text-[#002045]' : 'text-[#43474E]' }}"></i>
                </a>

                <a href="{{ url('admin/manajemen_psikolog') }}" class="w-full rounded p-3 flex items-center justify-between transition-colors {{ request()->is('admin/manajemen_psikolog') ? 'bg-[#D8E3FA] text-[#002045]' : 'hover:bg-slate-50 text-[#43474E]' }}">
                    <span class="text-[14px] leading-5 {{ request()->is('admin/manajemen_psikolog') ? 'font-semibold text-[#002045]' : 'font-medium text-[#43474E]' }}">Manajemen Psikolog</span>
                    <i class="fa-solid fa-user-md {{ request()->is('admin/manajemen_psikolog') ? 'text-[#002045]' : 'text-[#43474E]' }}"></i>
                </a>
                
                <div x-data="{ showLogoutModal: false }" class="mt-2 pt-3 border-t border-[#C4C6CF]">
                    <button @click="showLogoutModal = true" class="w-full hover:bg-[#FFDAD6] rounded p-3 flex items-center justify-between transition-colors mt-1 text-left group">
                        <span class="text-[#BA1A1A] text-[14px] font-bold leading-5 group-hover:text-[#93000a]">Logout</span>
                        <i class="fa-solid fa-arrow-right-from-bracket text-[#BA1A1A] group-hover:text-[#93000a]"></i>
                    </button>

                    <!-- Logout Confirmation Modal -->
                    <div x-show="showLogoutModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="logout-modal-title" role="dialog" aria-modal="true">
                        <div class="flex items-center justify-center min-h-screen px-4 py-8">
                            <div x-show="showLogoutModal" x-transition.opacity class="fixed inset-0 bg-black/50" @click="showLogoutModal = false"></div>
                            <div x-show="showLogoutModal" x-transition class="relative bg-white rounded-lg shadow-xl max-w-md w-full p-6 text-left">
                                <h3 class="text-lg font-semibold text-[#111C2C] mb-4" id="logout-modal-title">Konfirmasi Logout</h3>
                                <p class="text-[#43474E] mb-6 font-normal">Apakah Anda yakin ingin keluar?</p>
                                <div class="flex justify-end space-x-3">
                                    <button @click="showLogoutModal = false" class="px-4 py-2 bg-gray-200 text-[#43474E] rounded hover:bg-gray-300 transition-colors">Batal</button>
                                    <a href="{{ url('admin/logout') }}" class="px-4 py-2 bg-[#BA1A1A] text-white rounded hover:bg-[#93000a] transition-colors">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content Area -->
            <div class="flex-1 min-w-0 bg-white border border-[#C4C6CF] rounded-lg p-6 shadow-sm overflow-hidden">
                @hasSection('page_title')
                    <div class="mb-6 pb-4 border-b border-[#C4C6CF]">
                        <h2 class="text-2xl font-bold text-[#002045]">@yield('page_title')</h2>
                    </div>
                @endif
                
                @yield('content')
            </div>
        </div>
    </main>
    
    @stack('scripts')
</body>
</html>

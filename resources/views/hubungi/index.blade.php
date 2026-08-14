@extends('layouts.app')
@section('content')

<div class="flex flex-col gap-12 font-['Inter'] items-center w-full max-w-7xl mx-auto py-12">
    
    <!-- Search Section -->
    <div class="flex flex-col items-center gap-3 w-full max-w-[768px] mx-auto text-center px-4">
        <h1 class="text-[#002045] text-4xl md:text-[48px] font-bold leading-[56px]">Pusat Bantuan</h1>
        <p class="text-[#43474E] text-[18px] leading-[28px] w-full">Temukan jawaban atas pertanyaan Anda mengenai layanan E-Konseling Pemerintah.</p>
        
        <div class="w-full relative mt-6">
            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-[#6B7280]"></i>
            </div>
            <input type="text" class="w-full bg-[#F9F9FF] border border-[#C4C6CF] shadow-sm rounded pl-12 pr-4 py-4 text-[#6B7280] text-[16px] focus:outline-none focus:border-[#002045] focus:ring-1 focus:ring-[#002045]" placeholder="Ketik topik bantuan, misalnya: 'Cara mendaftar konseling'...">
        </div>
    </div>

    <!-- Section - Categories -->
    <div class="w-full px-4 md:px-20 mt-12">
        <h2 class="text-[#002045] text-[24px] font-semibold leading-[32px] mb-6">Kategori Topik</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Category Card 1 -->
            <a href="#" class="bg-[#F9F9FF] border border-[#C4C6CF] rounded-lg p-6 flex flex-col gap-3 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-[#E1E6F3] rounded-full flex items-center justify-center text-[#002045]">
                    <i class="fa-solid fa-circle-info text-xl"></i>
                </div>
                <h3 class="text-[#111C2C] text-[18px] font-semibold leading-[28px]">Tentang Layanan</h3>
                <p class="text-[#43474E] text-[14px] leading-[20px]">Informasi umum layanan kami.</p>
            </a>

            <!-- Category Card 2 -->
            <a href="#" class="bg-[#F9F9FF] border border-[#C4C6CF] rounded-lg p-6 flex flex-col gap-3 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-[#E1E6F3] rounded-full flex items-center justify-center text-[#002045]">
                    <i class="fa-solid fa-shield-halved text-xl"></i>
                </div>
                <h3 class="text-[#111C2C] text-[18px] font-semibold leading-[28px]">Privasi & Data</h3>
                <p class="text-[#43474E] text-[14px] leading-[20px]">Kebijakan kerahasiaan Anda.</p>
            </a>

            <!-- Category Card 3 -->
            <a href="#" class="bg-[#F9F9FF] border border-[#C4C6CF] rounded-lg p-6 flex flex-col gap-3 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-[#E1E6F3] rounded-full flex items-center justify-center text-[#002045]">
                    <i class="fa-solid fa-book-open text-xl"></i>
                </div>
                <h3 class="text-[#111C2C] text-[18px] font-semibold leading-[28px]">Panduan Penggunaan</h3>
                <p class="text-[#43474E] text-[14px] leading-[20px]">Langkah demi langkah mendaftar.</p>
            </a>

            <!-- Category Card 4 (Emergency) -->
            <a href="#" class="bg-[rgba(255,218,214,0.2)] border border-[#FFDAD6] rounded-lg p-6 flex flex-col gap-3 hover:shadow-md transition-shadow relative overflow-hidden group">
                <div class="absolute -top-10 -right-10 w-24 h-24 bg-[rgba(186,26,26,0.1)] rounded-full group-hover:scale-150 transition-transform duration-500"></div>
                <div class="w-12 h-12 bg-[#FFDAD6] rounded-full flex items-center justify-center text-[#93000A] relative z-10">
                    <i class="fa-solid fa-truck-medical text-xl"></i>
                </div>
                <h3 class="text-[#93000A] text-[18px] font-semibold leading-[28px] relative z-10">Kontak Darurat</h3>
                <p class="text-[#43474E] text-[14px] leading-[20px] relative z-10">Bantuan mendesak segera.</p>
            </a>

        </div>
    </div>

    <!-- Section - FAQ Accordion -->
    <div class="w-full px-4 md:px-20 mt-12" x-data="{ activeAccordion: null }">
        <div class="flex flex-wrap items-center justify-between mb-6">
            <h2 class="text-[#002045] text-[24px] font-semibold leading-[32px]">Pertanyaan yang Sering Diajukan</h2>
            <a href="#" class="text-[#13696A] text-[14px] font-medium leading-[20px] hover:underline">Lihat Semua FAQ</a>
        </div>
        
        <div class="flex flex-col gap-3">
            <!-- FAQ Item 1 -->
            <div class="bg-[#F9F9FF] border border-[#C4C6CF] rounded overflow-hidden">
                <button @click="activeAccordion = activeAccordion === 1 ? null : 1" class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none hover:bg-slate-50 transition-colors">
                    <span class="text-[#111C2C] text-[14px] font-semibold leading-[20px]">Bagaimana cara mendaftar sesi konseling pertama?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300" :class="{ 'rotate-180': activeAccordion === 1 }"></i>
                </button>
                <div x-show="activeAccordion === 1" x-collapse>
                    <div class="px-6 pb-4 text-[#43474E] text-[14px] leading-[20px]">
                        Anda dapat mendaftar dengan membuat akun melalui tombol "Login Warga", kemudian pilih menu "Daftar". Setelah memiliki akun, Anda bisa masuk ke Dashboard Warga dan memilih "Jadwalkan Sesi Baru" untuk memilih psikolog dan waktu konseling.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 2 -->
            <div class="bg-[#F9F9FF] border border-[#C4C6CF] rounded overflow-hidden">
                <button @click="activeAccordion = activeAccordion === 2 ? null : 2" class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none hover:bg-slate-50 transition-colors">
                    <span class="text-[#111C2C] text-[14px] font-semibold leading-[20px]">Apakah sesi konseling ini dipungut biaya?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300" :class="{ 'rotate-180': activeAccordion === 2 }"></i>
                </button>
                <div x-show="activeAccordion === 2" x-collapse>
                    <div class="px-6 pb-4 text-[#43474E] text-[14px] leading-[20px]">
                        Layanan E-Konseling Pemerintah disediakan secara gratis untuk seluruh warga negara Indonesia.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 3 -->
            <div class="bg-[#F9F9FF] border border-[#C4C6CF] rounded overflow-hidden">
                <button @click="activeAccordion = activeAccordion === 3 ? null : 3" class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none hover:bg-slate-50 transition-colors">
                    <span class="text-[#111C2C] text-[14px] font-semibold leading-[20px]">Apakah data pribadi dan cerita saya dijamin kerahasiaannya?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300" :class="{ 'rotate-180': activeAccordion === 3 }"></i>
                </button>
                <div x-show="activeAccordion === 3" x-collapse>
                    <div class="px-6 pb-4 text-[#43474E] text-[14px] leading-[20px]">
                        Ya, kami menjamin kerahasiaan 100%. Semua data pribadi dan riwayat konseling dilindungi dengan enkripsi tingkat tinggi sesuai standar keamanan pemerintah.
                    </div>
                </div>
            </div>

            <!-- FAQ Item 4 -->
            <div class="bg-[#F9F9FF] border border-[#C4C6CF] rounded overflow-hidden">
                <button @click="activeAccordion = activeAccordion === 4 ? null : 4" class="w-full px-6 py-4 flex items-center justify-between text-left focus:outline-none hover:bg-slate-50 transition-colors">
                    <span class="text-[#111C2C] text-[14px] font-semibold leading-[20px]">Apa yang harus saya lakukan jika dalam kondisi darurat krisis?</span>
                    <i class="fa-solid fa-chevron-down text-slate-400 transition-transform duration-300" :class="{ 'rotate-180': activeAccordion === 4 }"></i>
                </button>
                <div x-show="activeAccordion === 4" x-collapse>
                    <div class="px-6 pb-4 text-[#43474E] text-[14px] leading-[20px]">
                        Jika Anda sedang dalam kondisi krisis atau darurat, segera hubungi nomor layanan darurat 119 bebas pulsa yang tersedia 24 jam.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Section - Emergency Support Banner -->
    <div class="w-full px-4 md:px-20 mt-12 mb-8">
        <div class="bg-[#1A365D] rounded-2xl p-8 md:p-12 relative overflow-hidden shadow-sm flex flex-col md:flex-row items-center justify-between gap-8 text-white">
            <!-- Optional Background Image overlay based on Figma's backgroundImage -->
            <div class="absolute inset-0 bg-gradient-to-r from-[#1A365D] to-[#1e457c] opacity-90"></div>
            
            <div class="relative z-10 flex flex-col gap-3 max-w-2xl">
                <h2 class="text-[30px] font-bold leading-[38px]">Butuh Bantuan Segera?</h2>
                <p class="text-[rgba(255,255,255,0.8)] text-[16px] leading-[24px]">
                    Layanan krisis 24 jam kami siap mendengarkan. Anda tidak sendirian.<br>
                    Silakan hubungi nomor darurat kami untuk pendampingan segera.
                </p>
            </div>

            <div class="relative z-10 flex flex-col gap-3 w-full md:w-auto">
                <a href="tel:119" class="bg-[#BA1A1A] hover:bg-red-800 text-white rounded-xl px-6 py-3 flex items-center justify-center gap-2 transition-colors shadow-md w-full md:w-[218px] h-[44px]">
                    <i class="fa-solid fa-phone"></i>
                    <span class="font-medium text-[14px]">Hubungi Darurat 119</span>
                </a>
                <a href="#" class="bg-[rgba(249,249,255,0.1)] border border-[rgba(249,249,255,0.3)] hover:bg-[rgba(249,249,255,0.2)] text-white rounded-xl px-6 py-3 flex items-center justify-center gap-2 transition-colors w-full md:w-[220px] h-[46px]">
                    <i class="fa-regular fa-comment-dots"></i>
                    <span class="font-medium text-[14px]">Chat Konselor Siaga</span>
                </a>
            </div>
        </div>
    </div>

</div>

@endsection

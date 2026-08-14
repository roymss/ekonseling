@extends('layouts.app')
@section('content')

<div class="font-['Inter']">
    
    <!-- Hero Section with Light Background -->
    <div class="relative w-full bg-gradient-to-b from-[#F2F6FF] to-white overflow-hidden border-b border-[#E1E6F3]">
        
        <!-- Decorative subtle shapes -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-bl from-[#E8F0FE]/40 to-transparent pointer-events-none"></div>
        <div class="absolute -top-20 -left-20 w-[400px] h-[400px] rounded-full bg-[#E8F0FE]/30 blur-3xl pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 md:px-20 pt-16 pb-24 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-8">
                
                <!-- Left Text Content -->
                <div class="flex-1 flex flex-col gap-6">
                    <div class="w-fit bg-[#E8F0FE] text-[#002045] text-[12px] font-semibold px-4 py-1.5 rounded-full">
                        Layanan Resmi Pemerintah
                    </div>
                    
                    <h1 class="text-[#002045] text-[36px] lg:text-[48px] font-bold leading-[1.2] tracking-tight">
                        Kesehatan Mental &<br>
                        Kesejahteraan Anda<br>
                        Adalah Prioritas Kami
                    </h1>
                    
                    <p class="text-[#43474E] text-[16px] leading-[24px] max-w-lg">
                        Dapatkan akses mudah dan rahasia ke tenaga profesional psikologi berlisensi. Kami hadir untuk mendampingi Anda melewati berbagai tantangan emosional.
                    </p>
                    
                    <div class="flex flex-wrap items-center gap-4 mt-2">
                        <a href="{{ url('user/konsultasi_tambah') }}" class="bg-[#002045] hover:bg-[#001530] text-white text-[14px] font-medium px-6 py-3 rounded flex items-center gap-2 transition-colors">
                            <span>Mulai Konseling</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                        <a href="#layanan" class="border border-[#002045] hover:bg-slate-50 text-[#002045] text-[14px] font-medium px-6 py-3 rounded transition-colors">
                            Pelajari Selengkapnya
                        </a>
                    </div>
                </div>

                <!-- Right Illustration -->
                <div class="flex-1 relative w-full flex justify-center lg:justify-end">
                    <div class="relative w-full max-w-[500px]">
                        <!-- The Illustration Image -->
                        <img src="{{ url('asset/images/hero_illustration.png') }}" alt="Ilustrasi Konseling" class="w-full h-auto object-contain rounded-2xl shadow-sm border border-slate-100">
                        
                        <!-- Floating Trust Badge -->
                        <div class="absolute -bottom-6 -left-6 md:-bottom-8 md:-left-8 bg-white rounded-lg p-3 md:p-4 shadow-lg border border-[#E1E6F3] flex items-center gap-3 w-fit animate-bounce-slow">
                            <div class="bg-[#002045] text-white w-10 h-10 rounded flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-shield-halved"></i>
                            </div>
                            <div class="flex flex-col">
                                <span class="text-[#111C2C] text-[14px] font-bold">100% Rahasia & Aman</span>
                                <span class="text-[#43474E] text-[12px]">Data dilindungi negara</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div id="layanan" class="max-w-7xl mx-auto px-4 md:px-20 py-20">
        
        <!-- Section Header -->
        <div class="text-center max-w-2xl mx-auto mb-16 flex flex-col gap-4">
            <h2 class="text-[#002045] text-[32px] font-bold leading-tight">Layanan Unggulan Kami</h2>
            <p class="text-[#43474E] text-[16px] leading-[24px]">
                Pilih layanan konseling yang sesuai dengan kebutuhan spesifik Anda. Semua sesi ditangani oleh ahli bersertifikat.
            </p>
        </div>

        <!-- Services Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <!-- Service Card 1 -->
            <div class="bg-white border border-[#C4C6CF] rounded-xl p-8 flex flex-col gap-4 hover:shadow-lg transition-all hover:-translate-y-1">
                <div class="w-14 h-14 bg-[#F2F6FF] rounded flex items-center justify-center text-[#002045] mb-2">
                    <i class="fa-regular fa-user text-2xl"></i>
                </div>
                <h3 class="text-[#111C2C] text-[20px] font-bold">Konseling Individu</h3>
                <p class="text-[#43474E] text-[14px] leading-[24px] flex-grow">
                    Bantuan personal untuk mengelola stres, kecemasan, depresi, atau masalah pribadi lainnya dalam lingkungan yang aman.
                </p>
                <a href="{{ url('user/konsultasi_tambah') }}" class="text-[#002045] text-[14px] font-semibold flex items-center gap-2 hover:underline mt-2 w-fit">
                    <span>Daftar Sekarang</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Service Card 2 -->
            <div class="bg-white border border-[#C4C6CF] rounded-xl p-8 flex flex-col gap-4 hover:shadow-lg transition-all hover:-translate-y-1">
                <div class="w-14 h-14 bg-[#F2F6FF] rounded flex items-center justify-center text-[#002045] mb-2">
                    <i class="fa-solid fa-user-group text-2xl"></i>
                </div>
                <h3 class="text-[#111C2C] text-[20px] font-bold">Konseling Keluarga</h3>
                <p class="text-[#43474E] text-[14px] leading-[24px] flex-grow">
                    Fasilitasi komunikasi dan penyelesaian konflik untuk menciptakan hubungan keluarga yang lebih harmonis dan sehat.
                </p>
                <a href="{{ url('user/konsultasi_tambah') }}" class="text-[#002045] text-[14px] font-semibold flex items-center gap-2 hover:underline mt-2 w-fit">
                    <span>Daftar Sekarang</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            <!-- Service Card 3 -->
            <div class="bg-white border border-[#C4C6CF] rounded-xl p-8 flex flex-col gap-4 hover:shadow-lg transition-all hover:-translate-y-1">
                <div class="w-14 h-14 bg-[#F2F6FF] rounded flex items-center justify-center text-[#002045] mb-2">
                    <i class="fa-solid fa-briefcase text-2xl"></i>
                </div>
                <h3 class="text-[#111C2C] text-[20px] font-bold">Konseling Karir</h3>
                <p class="text-[#43474E] text-[14px] leading-[24px] flex-grow">
                    Bimbingan profesional untuk merencanakan jalur karir, mengatasi burnout, dan mengembangkan potensi diri di tempat kerja.
                </p>
                <a href="{{ url('user/konsultasi_tambah') }}" class="text-[#002045] text-[14px] font-semibold flex items-center gap-2 hover:underline mt-2 w-fit">
                    <span>Daftar Sekarang</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

        </div>
    </div>
</div>

<style>
    .animate-bounce-slow {
        animation: bounce-slow 3s infinite;
    }
    @keyframes bounce-slow {
        0%, 100% {
            transform: translateY(-5%);
            animation-timing-function: cubic-bezier(0.8,0,1,1);
        }
        50% {
            transform: none;
            animation-timing-function: cubic-bezier(0,0,0.2,1);
        }
    }
</style>

@endsection


@extends('layouts.app')
@section('content')
<div class="w-full bg-[#F9F9FF] font-['Inter']" x-data="profileDashboard()">
    <div class="max-w-[1280px] mx-auto py-12 px-4 md:px-20 flex flex-col md:flex-row gap-6 items-start">
        
        <!-- Aside - Local Sidebar Navigation -->
        <aside class="w-full md:w-[256px] flex-shrink-0 bg-white border border-[#C4C6CF] rounded-lg p-3 flex flex-col gap-1">
            <div class="px-3 py-3 border-b border-[#C4C6CF] mb-1">
                <span class="text-[#43474E] text-[12px] leading-4">Menu Dashboard</span>
            </div>
            
            <a href="#" @click.prevent="tab = 'ringkasan'" :class="tab === 'ringkasan' ? 'bg-[#D8E3FA] text-[#002045]' : 'hover:bg-slate-50 text-[#43474E]'" class="w-full rounded p-3 flex items-center justify-between transition-colors">
                <span class="text-[14px] font-semibold leading-5" :class="tab === 'ringkasan' ? 'text-[#002045]' : 'text-[#43474E]'">Ringkasan</span>
                <i class="fa-solid fa-chart-pie" :class="tab === 'ringkasan' ? 'text-[#002045]' : 'text-[#43474E]'"></i>
            </a>
            
            <a href="#" @click.prevent="tab = 'sesi'" :class="tab === 'sesi' ? 'bg-[#D8E3FA] text-[#002045]' : 'hover:bg-slate-50 text-[#43474E]'" class="w-full rounded p-3 flex items-center justify-between transition-colors">
                <span class="text-[14px] font-semibold leading-5" :class="tab === 'sesi' ? 'text-[#002045]' : 'text-[#43474E]'">Sesi Saya</span>
                <i class="fa-regular fa-calendar" :class="tab === 'sesi' ? 'text-[#002045]' : 'text-[#43474E]'"></i>
            </a>
            
            <a href="#" @click.prevent="tab = 'pesan'; activeChat = null" :class="tab === 'pesan' ? 'bg-[#D8E3FA] text-[#002045]' : 'hover:bg-slate-50 text-[#43474E]'" class="w-full rounded p-3 flex items-center justify-between transition-colors">
                <div class="flex items-center gap-3">
                    <span class="text-[14px] font-semibold leading-5" :class="tab === 'pesan' ? 'text-[#002045]' : 'text-[#43474E]'">Pesan</span>
                </div>
                <div class="flex items-center gap-2">
                    <span x-show="totalUnread > 0" x-text="totalUnread" class="bg-[#BA1A1A] text-white text-[12px] font-medium rounded-full px-2 py-0.5 leading-4" style="display: none;"></span>
                    <i class="fa-regular fa-message" :class="tab === 'pesan' ? 'text-[#002045]' : 'text-[#43474E]'"></i>
                </div>
            </a>
            
            <a href="#" @click.prevent="tab = 'catatan'" :class="tab === 'catatan' ? 'bg-[#D8E3FA] text-[#002045]' : 'hover:bg-slate-50 text-[#43474E]'" class="w-full rounded p-3 flex items-center justify-between transition-colors">
                <span class="text-[14px] font-semibold leading-5" :class="tab === 'catatan' ? 'text-[#002045]' : 'text-[#43474E]'">Catatan Klinis</span>
                <i class="fa-regular fa-clipboard" :class="tab === 'catatan' ? 'text-[#002045]' : 'text-[#43474E]'"></i>
            </a>
            
            <div class="mt-2 pt-3 border-t border-[#C4C6CF]">
                <a href="#" @click.prevent="tab = 'pengaturan'" :class="tab === 'pengaturan' ? 'bg-[#D8E3FA] text-[#002045]' : 'hover:bg-slate-50 text-[#43474E]'" class="w-full rounded p-3 flex items-center justify-between transition-colors">
                    <span class="text-[14px] font-medium leading-5" :class="tab === 'pengaturan' ? 'text-[#002045] font-semibold' : 'text-[#43474E]'">Pengaturan Privasi</span>
                    <i class="fa-solid fa-gear" :class="tab === 'pengaturan' ? 'text-[#002045]' : 'text-[#43474E]'"></i>
                </a>
                <a href="{{ url('user/logout') }}" onclick="return confirm('Apakah Anda yakin ingin keluar?')" class="w-full hover:bg-[#FFDAD6] rounded p-3 flex items-center justify-between transition-colors mt-1">
                    <span class="text-[#BA1A1A] text-[14px] font-bold leading-5">Logout</span>
                    <i class="fa-solid fa-arrow-right-from-bracket text-[#BA1A1A]"></i>
                </a>
            </div>
        </aside>

        <!-- Main Content Canvas -->
        <main class="w-full md:flex-1 flex flex-col gap-6 relative">
            
            <!-- Page Header & Global Action -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex flex-col gap-1">
                    @php
                        $nama = explode(' ', $row['nama_lengkap'] ?? 'Budi');
                        $nama_depan = $nama[0] ?? 'Budi';

                        $sesi_global = \Illuminate\Support\Facades\DB::table('konsul')
                                        ->where('username', session('username'))
                                        ->get();
                        $room_unreads = [];
                        foreach($sesi_global as $k) {
                            $room_unreads[$k->id_konsul] = \Illuminate\Support\Facades\DB::table('komentar_konsul')
                                ->where('id_konsul', $k->id_konsul)
                                ->where('url', '!=', session('username'))
                                ->where('dibaca', 'N')
                                ->count();
                        }
                    @endphp
                    <h1 class="text-[#111C2C] text-[24px] font-semibold leading-8">Selamat Datang, {{ $nama_depan }}</h1>
                    <p class="text-[#43474E] text-[16px] leading-6">Berikut adalah ringkasan aktivitas konseling Anda.</p>
                </div>
                <button type="button" @click.prevent="$dispatch('open-new-session')" class="bg-[#002045] hover:bg-[#001530] text-white px-6 py-3 rounded-lg flex items-center gap-2 shadow-sm transition-colors">
                    <span class="font-medium text-[14px] leading-5">Jadwalkan Sesi Baru</span>
                    <i class="fa-solid fa-plus text-sm"></i>
                </button>
            </div>

            <!-- Tab 1: Ringkasan -->
            <div x-show="tab === 'ringkasan'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="flex flex-col gap-6">
                <!-- Bento Grid Layout -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Widget: Sesi Mendatang (Spans 2 columns on large screens) -->
                    <div class="lg:col-span-2 bg-white border border-[#C4C6CF] rounded-lg p-6 flex flex-col gap-6 relative overflow-hidden min-h-[298px]">
                        <div class="absolute right-0 top-0 w-32 h-32 bg-[#D8E3FA] rounded-bl-full opacity-50 pointer-events-none"></div>
                        
                        <div class="flex justify-between items-start z-10">
                            <div class="flex items-center gap-2">
                                <i class="fa-regular fa-calendar-check text-[#111C2C]"></i>
                                <h2 class="text-[#111C2C] text-[14px] font-semibold leading-5 uppercase tracking-wide">SESI MENDATANG</h2>
                            </div>
                            <span class="bg-[#D8E3FA] text-[#002045] text-[12px] font-medium px-3 py-1 rounded-full leading-4">Informasi Sesi</span>
                        </div>

                        <div class="bg-[#F9F9FF] border border-[#C4C6CF] rounded p-4 flex flex-col gap-3 z-10 h-full justify-center">
                            @php
                                $sesi_mendatang = \Illuminate\Support\Facades\DB::table('konsul')
                                                ->leftJoin('users', 'konsul.username_psikolog', '=', 'users.username')
                                                ->select('konsul.*', 'users.nama_lengkap as nama_psikolog')
                                                ->where('konsul.username', session('username'))
                                                ->orderBy('konsul.id_konsul', 'desc')
                                                ->first();
                            @endphp
                            
                            @if($sesi_mendatang)
                            <div class="flex items-center justify-between border-b border-[#C4C6CF] pb-3">
                                <div>
                                    <h3 class="text-[#111C2C] text-[16px] font-bold">Konseling dengan {{ $sesi_mendatang->nama_psikolog ?? 'Konselor (Menunggu)' }}</h3>
                                    <p class="text-[#43474E] text-[14px]">Topik: {{ $sesi_mendatang->judul }}</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-[#002045] font-bold text-[16px]">{{ \Carbon\Carbon::parse($sesi_mendatang->tanggal)->format('d M Y') }}</div>
                                    <div class="text-[#43474E] text-[14px]">{{ $sesi_mendatang->jam }} WIB</div>
                                </div>
                            </div>
                            <div class="flex justify-end gap-3 pt-2">
                                <a href="{{ url('user/konsultasi') }}" class="text-[#BA1A1A] text-[14px] font-medium hover:underline">Jadwal Ulang</a>
                            </div>
                            @else
                            <div class="text-center py-4">
                                <p class="text-[#43474E] text-[14px]">Belum ada sesi mendatang.</p>
                                <button type="button" @click.prevent="$dispatch('open-new-session')" class="text-[#002045] font-semibold text-sm hover:underline mt-2 inline-block">Jadwalkan sekarang</button>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Profile Widget -->
                    <div class="bg-white border border-[#C4C6CF] rounded-lg p-6 flex flex-col items-center justify-center gap-4 text-center">
                        <img class="w-24 h-24 rounded-full object-cover border-4 border-[#F9F9FF] shadow-sm" src="{{ url('/') }}/asset/foto_user/{{ trim($row['foto'] ?? '') == '' ? 'users.gif' : $row['foto'] }}" alt="Foto Profile">
                        <div>
                            <h3 class="text-[#111C2C] text-[18px] font-bold">{{ $row['nama_lengkap'] ?? 'Budi Santoso' }}</h3>
                            <p class="text-[#43474E] text-[14px]">{{ $row['email'] ?? 'budi@example.com' }}</p>
                        </div>
                        <button type="button" @click.prevent="tab = 'pengaturan'" class="mt-2 w-full py-2 bg-[#F9F9FF] border border-[#C4C6CF] text-[#43474E] text-[14px] font-medium rounded hover:bg-[#E1E6F3] transition-colors">
                            Edit Profil
                        </button>
                    </div>
                </div>

                <!-- Profile Details Section -->
                <div class="bg-white rounded-lg shadow-sm border border-[#C4C6CF] overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-[#111C2C] text-[16px] font-bold border-b border-[#C4C6CF] pb-4 mb-4">Informasi Pribadi</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-6">
                            <div>
                                <span class="block text-xs font-semibold text-[#43474E] uppercase tracking-wider mb-1">No Telpon</span>
                                <span class="text-[#111C2C] font-medium">{{ $row['no_telp'] ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-[#43474E] uppercase tracking-wider mb-1">Jenis Kelamin</span>
                                <span class="text-[#111C2C] font-medium">{{ $row['jenis_kelamin'] ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-[#43474E] uppercase tracking-wider mb-1">Tempat Lahir</span>
                                <span class="text-[#111C2C] font-medium">{{ $row['tempat_lahir'] ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="block text-xs font-semibold text-[#43474E] uppercase tracking-wider mb-1">Tanggal Lahir</span>
                                <span class="text-[#111C2C] font-medium">{{ $row['tanggal_lahir'] ?? '-' }}</span>
                            </div>
                            <div class="md:col-span-2 mt-2">
                                <span class="block text-xs font-semibold text-[#43474E] uppercase tracking-wider mb-1">Alamat Lengkap</span>
                                <span class="text-[#111C2C] font-medium">{{ $row['alamat_lengkap'] ?? '-' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab 2: Sesi Saya -->
            <div x-show="tab === 'sesi'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="flex flex-col gap-6">
                <div class="bg-white border border-[#C4C6CF] rounded-lg p-6">
                    <h2 class="text-[#111C2C] text-[18px] font-bold border-b border-[#C4C6CF] pb-4 mb-4">Daftar Sesi Konseling Saya</h2>
                    
                    @php
                        $sesi_saya = \Illuminate\Support\Facades\DB::table('konsul')
                                        ->leftJoin('users', 'konsul.username_psikolog', '=', 'users.username')
                                        ->select('konsul.*', 'users.nama_lengkap as nama_psikolog')
                                        ->where('konsul.username', session('username'))
                                        ->orderBy('konsul.id_konsul', 'desc')
                                        ->get();
                    @endphp
                    
                    @if($sesi_saya->count() > 0)
                        <div class="space-y-4">
                            @foreach($sesi_saya as $k)
                            <div x-data="{ showModal: false }" class="flex flex-col md:flex-row justify-between items-start md:items-center bg-[#F9F9FF] border border-[#E1E6F3] p-4 rounded-lg hover:border-[#C4C6CF] transition-colors">
                                <div class="mb-3 md:mb-0">
                                    <h3 class="font-bold text-[#002045] text-base">Konseling dengan {{ $k->nama_psikolog ?? 'Konselor (Menunggu)' }}</h3>
                                    <p class="text-sm text-[#43474E] mt-1">
                                        <i class="fa-solid fa-tag mr-1"></i> Topik: {{ $k->judul }}
                                    </p>
                                    <p class="text-sm text-[#43474E] mt-1">
                                        <i class="fa-regular fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }} 
                                        <span class="mx-2">|</span> 
                                        <i class="fa-regular fa-clock mr-1"></i> {{ $k->jam }} WIB
                                    </p>
                                </div>
                                <div class="flex flex-col items-end gap-2 w-full md:w-auto">
                                    <span class="text-xs font-semibold px-3 py-1 rounded-full {{ strtolower($k->status) == 'dijawab' ? 'bg-green-100 text-green-700' : 'bg-[#E8F0FE] text-[#002045]' }}">
                                        Status: {{ $k->status ?? 'Menunggu' }}
                                    </span>
                                    <button type="button" @click.prevent="showModal = true" class="text-sm font-medium text-[#002045] border border-[#002045] px-4 py-1.5 rounded hover:bg-[#E8F0FE] transition-colors w-full md:w-auto text-center">Detail</button>
                                </div>

                                <!-- Detail Modal Popup for this session -->
                                <div x-show="showModal" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <!-- Background overlay -->
                                        <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 backdrop-blur-sm transition-opacity" style="background-color: rgba(0, 0, 0, 0.4);" aria-hidden="true" @click="showModal = false"></div>

                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                                        <!-- Modal panel -->
                                        <div x-show="showModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full z-50 relative">
                                            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-[#C4C6CF]">
                                                <div class="sm:flex sm:items-start">
                                                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-[#E8F0FE] sm:mx-0 sm:h-10 sm:w-10">
                                                        <i class="fa-solid fa-file-lines text-[#002045]"></i>
                                                    </div>
                                                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                        <h3 class="text-lg leading-6 font-bold text-[#002045]" id="modal-title">Konseling dengan {{ $k->nama_psikolog ?? 'Menunggu Konselor' }}</h3>
                                                        <div class="mt-4 space-y-3 w-full text-left">
                                                            <div>
                                                                <p class="text-xs font-bold text-[#43474E] uppercase">Topik</p>
                                                                <p class="text-sm text-[#111C2C]">{{ $k->judul }}</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs font-bold text-[#43474E] uppercase">Jadwal</p>
                                                                <p class="text-sm text-[#111C2C]">{{ \Carbon\Carbon::parse($k->tanggal)->format('d M Y') }} - {{ $k->jam }} WIB</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs font-bold text-[#43474E] uppercase">Status</p>
                                                                <p class="text-sm font-semibold inline-block px-2 py-0.5 mt-1 rounded bg-[#E8F0FE] text-[#002045]">{{ $k->status ?? 'Menunggu' }}</p>
                                                            </div>
                                                            <div>
                                                                <p class="text-xs font-bold text-[#43474E] uppercase">Keluhan Awal</p>
                                                                <div class="bg-[#F9F9FF] p-3 rounded border border-[#E1E6F3] mt-1">
                                                                    <p class="text-sm text-[#111C2C]">{{ trim(preg_replace('/\s+/', ' ', strip_tags($k->isi_konsul))) }}</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-[#C4C6CF]">
                                                <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#002045] text-base font-medium text-white hover:bg-[#001530] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#002045] sm:ml-3 sm:w-auto sm:text-sm" @click="showModal = false; tab = 'pesan'; initChat({{ $k->id_konsul }}, '{{ addslashes($k->nama_psikolog ?? 'Konselor') }}')">
                                                    Mulai Chat Konselor
                                                </button>
                                                <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-[#C4C6CF] shadow-sm px-4 py-2 bg-white text-base font-medium text-[#43474E] hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#002045] sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showModal = false">
                                                    Tutup
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <div class="text-[#C4C6CF] mb-3"><i class="fa-regular fa-calendar-xmark text-4xl"></i></div>
                            <p class="text-[#43474E] text-[16px] font-medium">Anda belum memiliki sesi konseling.</p>
                            <p class="text-[#43474E] text-[14px] mt-1 mb-4">Jadwalkan sesi pertama Anda untuk memulai perjalanan konseling.</p>
                            <button type="button" @click.prevent="$dispatch('open-new-session')" class="bg-[#002045] hover:bg-[#001530] text-white px-6 py-2 rounded-lg shadow-sm transition-colors text-sm">Jadwalkan Sekarang</button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tab 3: Pesan -->
            <div x-show="tab === 'pesan'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="flex flex-col gap-6 h-[550px]">
                
                <!-- Chat List View -->
                <div x-show="!activeChat" class="bg-white border border-[#C4C6CF] rounded-lg p-6 flex flex-col h-full shadow-sm">
                    <h2 class="text-[#111C2C] text-[18px] font-bold border-b border-[#C4C6CF] pb-4 mb-4">Pesan Masuk</h2>
                    
                    @if(isset($sesi_saya) && $sesi_saya->count() > 0)
                        <div class="space-y-2 overflow-y-auto flex-1">
                            @foreach($sesi_saya as $k)
                                <div @click="initChat({{ $k->id_konsul }}, '{{ addslashes($k->nama_psikolog ?? 'Konselor') }}')" class="cursor-pointer p-4 border rounded-lg transition-colors flex justify-between items-center" :class="(roomUnreads[{{ $k->id_konsul }}] || 0) > 0 ? 'bg-[#FDFDFD] border-[#002045] shadow-sm' : 'bg-[#F9F9FF] border-[#E1E6F3] hover:border-[#C4C6CF]'">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm relative transition-colors" :class="(roomUnreads[{{ $k->id_konsul }}] || 0) > 0 ? 'bg-[#002045] text-white' : 'bg-[#E8F0FE] text-[#002045]'">
                                            {{ strtoupper(substr($k->nama_psikolog ?? 'K', 0, 1)) }}
                                            <span x-show="(roomUnreads[{{ $k->id_konsul }}] || 0) > 0" class="absolute -top-1 -right-1 w-3 h-3 bg-[#BA1A1A] rounded-full border-2 border-white" style="display: none;"></span>
                                        </div>
                                        <div>
                                            <h3 class="text-sm transition-colors" :class="(roomUnreads[{{ $k->id_konsul }}] || 0) > 0 ? 'font-bold text-[#002045]' : 'font-semibold text-[#002045]'">{{ $k->nama_psikolog ?? 'Menunggu Konselor' }}</h3>
                                            <p class="text-xs mt-0.5 truncate max-w-[200px] sm:max-w-xs transition-colors" :class="(roomUnreads[{{ $k->id_konsul }}] || 0) > 0 ? 'text-[#111C2C] font-medium' : 'text-[#43474E]'">{{ $k->judul }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <span x-show="(roomUnreads[{{ $k->id_konsul }}] || 0) > 0" x-text="roomUnreads[{{ $k->id_konsul }}] + ' Baru'" class="text-[10px] font-bold text-white bg-[#BA1A1A] px-2 py-0.5 rounded-full" style="display: none;"></span>
                                        <div class="text-xs font-medium px-2 py-1 rounded transition-colors" :class="(roomUnreads[{{ $k->id_konsul }}] || 0) > 0 ? 'text-[#002045] bg-[#E8F0FE]' : 'text-[#43474E] bg-gray-100'">
                                            Buka Chat
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="flex-1 flex flex-col items-center justify-center text-center">
                            <div class="w-16 h-16 bg-[#E8F0FE] text-[#002045] rounded-full flex items-center justify-center mb-4">
                                <i class="fa-regular fa-message text-2xl"></i>
                            </div>
                            <h2 class="text-[#111C2C] text-[18px] font-bold mb-2">Kotak Masuk Kosong</h2>
                            <p class="text-[#43474E] text-[14px] max-w-md">Saat ini tidak ada pesan baru untuk Anda. Pesan dari psikolog akan muncul di sini jika Anda sudah menjadwalkan sesi.</p>
                        </div>
                    @endif
                </div>

                <!-- Active Chat View (AlpineJS SPA) -->
                <div x-show="activeChat !== null" style="display: none;" class="bg-white border border-[#C4C6CF] rounded-lg overflow-hidden flex flex-col h-full shadow-sm relative">
                    <!-- Chat Header -->
                    <div class="bg-[#002045] p-4 flex items-center justify-between z-10 shadow-sm">
                        <div class="flex items-center gap-3">
                            <button @click="closeChat()" class="text-white hover:bg-white/20 rounded-full w-8 h-8 flex items-center justify-center mr-1 transition-colors">
                                <i class="fa-solid fa-arrow-left"></i>
                            </button>
                            <div class="w-10 h-10 bg-white text-[#002045] rounded-full flex items-center justify-center font-bold text-sm" x-text="activePsikolog ? activePsikolog.charAt(0).toUpperCase() : 'K'">
                            </div>
                            <div>
                                <h3 class="text-white font-bold text-sm" x-text="activePsikolog || 'Menunggu Konselor'"></h3>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                                    <p class="text-white/80 text-xs font-medium" x-text="activeRoom ? 'Topik: ' + activeRoom.judul : 'Memuat...'"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Chat Messages -->
                    <div id="chat-messages-container" class="flex-1 p-4 bg-[#F9F9FF] overflow-y-auto space-y-4">
                        <div class="text-center mb-4" x-show="activeRoom">
                            <span class="text-xs text-[#43474E] bg-[#E1E6F3] px-3 py-1 rounded-full" x-text="'Sesi Konseling Dimulai (' + (activeRoom ? activeRoom.tanggal : '') + ')'"></span>
                        </div>
                        
                        <template x-for="msg in messages" :key="msg.id">
                            <div class="flex gap-3 items-end" :class="msg.is_me ? 'justify-end' : 'justify-start'">
                                <!-- Avatar for Received Message -->
                                <div x-show="!msg.is_me" class="w-8 h-8 bg-[#D8E3FA] text-[#002045] font-bold text-xs rounded-full flex-shrink-0 flex items-center justify-center" x-text="msg.sender.charAt(0).toUpperCase()">
                                </div>
                                
                                <!-- Message Bubble -->
                                <div :class="msg.is_me ? 'bg-[#002045] text-white rounded-2xl rounded-br-none' : 'bg-white border border-[#C4C6CF] text-[#111C2C] rounded-2xl rounded-bl-none'" class="p-3 text-sm max-w-[85%] shadow-sm">
                                    <p class="whitespace-pre-wrap" x-text="msg.text"></p>
                                    <div class="text-[10px] text-right mt-1" :class="msg.is_me ? 'text-white/70' : 'text-[#43474E]'">
                                        <span x-text="msg.time.substring(11, 16) + ' WIB'"></span>
                                        <i x-show="msg.is_me" class="fa-solid fa-check-double ml-1"></i>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <!-- Chat Input Form -->
                    <form @submit.prevent="sendMessage()" class="p-4 border-t border-[#C4C6CF] bg-white flex items-center gap-3">
                        <input type="text" id="chat-input" placeholder="Ketik pesan balasan..." class="flex-1 px-4 py-2 border border-[#C4C6CF] rounded-full bg-[#F9F9FF] focus:outline-none focus:border-[#002045] text-sm" required>
                        <button type="submit" class="w-9 h-9 bg-[#002045] text-white rounded-full flex flex-shrink-0 items-center justify-center hover:bg-[#001530] transition-colors">
                            <i class="fa-solid fa-paper-plane text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Tab 4: Catatan Klinis -->
            <div x-show="tab === 'catatan'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="flex flex-col gap-6">
                <div class="bg-white border border-[#C4C6CF] rounded-lg p-6 min-h-[300px] flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-[#E8F0FE] text-[#002045] rounded-full flex items-center justify-center mb-4">
                        <i class="fa-regular fa-clipboard text-2xl"></i>
                    </div>
                    <h2 class="text-[#111C2C] text-[18px] font-bold mb-2">Belum Ada Catatan Klinis</h2>
                    <p class="text-[#43474E] text-[14px] max-w-md">Catatan perkembangan konseling dari psikolog Anda akan direkap di sini setelah Anda menyelesaikan minimal satu sesi.</p>
                </div>
            </div>

            <!-- Tab 5: Pengaturan Privasi -->
            <div x-show="tab === 'pengaturan'" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="flex flex-col gap-6">
                @php 
                    $nama = explode(' ', $row['nama_lengkap'] ?? '');
                    $nama_belakang = isset($nama[1]) ? implode(' ', array_slice($nama, 1)) : '';
                @endphp

                <div class="bg-white rounded-2xl shadow-sm border border-[#C4C6CF] overflow-hidden mb-8">
                    <div class="p-6 md:p-10">
                        <h2 class="text-2xl font-bold text-[#002045] mb-6">Pengaturan Privasi & Profil</h2>
                        
                        <div class="bg-[#E8F0FE] border border-[#D8E3FA] p-6 rounded-2xl mb-8 shadow-sm">
                            <div class="flex gap-3">
                                <i class="fa-solid fa-circle-info text-[#002045] text-xl mt-0.5"></i>
                                <div class="text-[#002045] text-sm leading-relaxed">
                                    <strong>PENTING!</strong> Silakan mengisi form di bawah ini dengan data yang sebenarnya untuk keperluan administratif konseling Anda.
                                </div>
                            </div>
                        </div>

                        <form action="{{ url('user/edit_profile') }}" enctype='multipart/form-data' method="POST" onsubmit="
                            if (this.a.value == ''){ alert('Anda belum mengisikan Username'); this.a.focus(); return false; }								
                            if (this.c.value == ''){ alert('Anda belum menuliskan Nama Lengkap'); this.c.focus(); return false; }
                            if (this.d.value == ''){ alert('Anda belum menuliskan Email'); this.d.focus(); return false; }
                            if (this.e.value == ''){ alert('Anda belum menuliskan No Telpon'); this.e.focus(); return false; }																		
                            return true;
                        ">
                            @csrf
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <!-- Akun -->
                                <div class="space-y-5 md:col-span-2">
                                    <h4 class="text-lg font-bold text-[#111C2C] border-b border-[#E1E6F3] pb-3 mb-2">Informasi Akun</h4>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">Username <span class="text-[#BA1A1A]">*</span></label>
                                    <input type="text" name='a' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-slate-100 text-[#43474E] focus:outline-none text-sm cursor-not-allowed" placeholder="Username" value="{{ $row['username'] ?? '' }}" maxlength="50" onkeyup="nospaces(this)" required readonly>
                                    <p class="text-xs text-[#43474E] mt-2">Username tidak dapat diubah.</p>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">Password Baru</label>
                                    <input type="password" name='b' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" placeholder="Kosongkan jika tidak ingin mengubah password" maxlength="50">
                                </div>

                                <!-- Biodata -->
                                <div class="space-y-5 md:col-span-2 mt-4">
                                    <h4 class="text-lg font-bold text-[#111C2C] border-b border-[#E1E6F3] pb-3 mb-2">Informasi Pribadi</h4>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">Nama Depan <span class="text-[#BA1A1A]">*</span></label>
                                    <input type="text" name='c' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" value="{{ $nama[0] ?? '' }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">Nama Belakang <span class="text-[#BA1A1A]">*</span></label>
                                    <input type="text" name='cc' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" value="{{ $nama_belakang }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">Alamat Email <span class="text-[#BA1A1A]">*</span></label>
                                    <input type="email" name='d' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" placeholder="nama_anda@mail.com" value="{{ $row['email'] ?? '' }}" onkeyup="nospaces(this)" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">No Telpon / HP <span class="text-[#BA1A1A]">*</span></label>
                                    <input type="number" name='e' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" placeholder="08XXXXXXXXXX" value="{{ $row['no_telp'] ?? '' }}" maxlength="15" onkeyup="nospaces(this)" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">Jenis Kelamin <span class="text-[#BA1A1A]">*</span></label>
                                    <div class="flex items-center space-x-6 mt-3">
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name='kelamin' value='Laki-laki' class="form-radio text-[#002045] focus:ring-[#002045] w-4 h-4" {{ ($row['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-[#43474E]">Laki-laki</span>
                                        </label>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="radio" name='kelamin' value='Perempuan' class="form-radio text-[#002045] focus:ring-[#002045] w-4 h-4" {{ ($row['jenis_kelamin'] ?? '') == 'Perempuan' ? 'checked' : '' }}>
                                            <span class="ml-2 text-sm text-[#43474E]">Perempuan</span>
                                        </label>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">Pekerjaan / Perangkat Daerah <span class="text-[#BA1A1A]">*</span></label>
                                    <input type="text" name='perangkat_daerah' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" value="{{ $row['perangkat_daerah'] ?? '' }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">Tempat Lahir <span class="text-[#BA1A1A]">*</span></label>
                                    <input type="text" name='tempat_lahir' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" value="{{ $row['tempat_lahir'] ?? '' }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">Tanggal Lahir <span class="text-[#BA1A1A]">*</span></label>
                                    <input type="date" name='tanggal_lahir' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm datepicker" value="{{ $row['tanggal_lahir'] ?? '' }}" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">Status Pernikahan <span class="text-[#BA1A1A]">*</span></label>
                                    <select name='status' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" required>
                                        @foreach(['Kawin', 'Belum Kawin', 'Duda / Janda'] as $status)
                                            <option value="{{ $status }}" {{ ($row['status_kawin'] ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">Agama <span class="text-[#BA1A1A]">*</span></label>
                                    <select name='agama' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" required>
                                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'] as $agama)
                                            <option value="{{ $agama }}" {{ ($row['agama'] ?? '') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">Alamat Lengkap <span class="text-[#BA1A1A]">*</span></label>
                                    <textarea name='alamat' rows="3" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" required>{{ $row['alamat_lengkap'] ?? '' }}</textarea>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-[#111C2C] mb-2">Kode Keamanan <span class="text-[#BA1A1A]">*</span></label>
                                    <div class="flex items-center gap-4">
                                        <div class="bg-white p-2 rounded-xl border border-[#C4C6CF] shadow-sm">
                                            {!! $image !!}
                                        </div>
                                        <input name='secutity_code' type="text" class="w-full sm:w-1/2 px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" placeholder="Masukkan kode captcha" maxlength="6" onkeyup="nospaces(this)" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-8 pt-8 border-t border-[#E1E6F3] flex flex-col sm:flex-row gap-4">
                                <button type="submit" name='submit' class="bg-[#002045] hover:bg-[#001530] text-white font-medium py-3 px-6 rounded-xl shadow-sm transition-colors flex items-center justify-center">
                                    <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </div>

    <!-- New Session Modal -->
    <div x-data="{ showNewSession: false }" @open-new-session.window="showNewSession = true" x-show="showNewSession" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 backdrop-blur-sm transition-opacity" style="background-color: rgba(0, 0, 0, 0.4);" aria-hidden="true" @click="showNewSession = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="showNewSession" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full z-50 relative">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-[#C4C6CF]">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg leading-6 font-bold text-[#002045]" id="modal-title">Jadwalkan Sesi Baru</h3>
                        <button type="button" @click="showNewSession = false" class="text-gray-400 hover:text-gray-600"><i class="fa-solid fa-times"></i></button>
                    </div>
                    
                    <form onsubmit="submitNewSession(event)" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-[#43474E] mb-1">Kategori</label>
                            <select name="kategori" class="w-full px-4 py-2 border border-[#C4C6CF] rounded-md focus:ring-[#002045] focus:border-[#002045] text-sm bg-[#F9F9FF]" required>
                                <option value="">- Pilih Kategori -</option>
                                @php $kategori = \Illuminate\Support\Facades\DB::table('kategori_konsul')->where('aktif', 'Y')->get(); @endphp
                                @foreach ($kategori as $row_kat)
                                    <option value="{{ $row_kat->id_kategori_konsul }}">{{ $row_kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#43474E] mb-1">Pilih Psikolog</label>
                            <select name="psikolog" class="w-full px-4 py-2 border border-[#C4C6CF] rounded-md focus:ring-[#002045] focus:border-[#002045] text-sm bg-[#F9F9FF]" required>
                                <option value="">- Pilih Psikolog -</option>
                                @php $psikologs = \Illuminate\Support\Facades\DB::table('users')->where('level', 'psikolog')->get(); @endphp
                                @foreach ($psikologs as $p)
                                    <option value="{{ $p->username }}">{{ $p->nama_lengkap }} ({{ $p->perangkat_daerah ?? 'Psikolog' }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#43474E] mb-1">Judul / Topik</label>
                            <input type="text" name="judul" class="w-full px-4 py-2 border border-[#C4C6CF] rounded-md focus:ring-[#002045] focus:border-[#002045] text-sm bg-[#F9F9FF]" placeholder="Contoh: Kecemasan berlebih saat ujian" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-[#43474E] mb-1">Keluhan Awal</label>
                            <textarea name="pesan" rows="4" class="w-full px-4 py-2 border border-[#C4C6CF] rounded-md focus:ring-[#002045] focus:border-[#002045] text-sm bg-[#F9F9FF]" placeholder="Ceritakan keluhan Anda secara singkat..." required></textarea>
                        </div>
                        <div class="pt-2 flex justify-end gap-3 border-t border-[#C4C6CF] mt-4 p-4 -mx-4 -mb-4 bg-gray-50">
                            <button type="button" @click="showNewSession = false" class="px-4 py-2 text-[#43474E] bg-white border border-[#C4C6CF] hover:bg-gray-50 rounded-md text-sm font-medium transition-colors">Batal</button>
                            <button type="submit" class="px-4 py-2 text-white bg-[#002045] hover:bg-[#001530] rounded-md text-sm font-medium transition-colors">
                                Jadwalkan Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal Popup -->
    <div x-show="showDetail" style="display: none;" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div x-show="showDetail" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="showDetail = false"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <!-- Modal panel -->
            <div x-show="showDetail" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-[#C4C6CF]">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-[#E8F0FE] sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fa-solid fa-file-lines text-[#002045]"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-[#002045]" id="modal-title" x-text="'Konseling dengan ' + activeDetail.psikolog"></h3>
                            <div class="mt-4 space-y-3 w-full text-left">
                                <div>
                                    <p class="text-xs font-bold text-[#43474E] uppercase">Topik</p>
                                    <p class="text-sm text-[#111C2C]" x-text="activeDetail.judul"></p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-[#43474E] uppercase">Jadwal</p>
                                    <p class="text-sm text-[#111C2C]" x-text="activeDetail.tanggal + ' - ' + activeDetail.jam"></p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-[#43474E] uppercase">Status</p>
                                    <p class="text-sm font-semibold inline-block px-2 py-0.5 mt-1 rounded bg-[#E8F0FE] text-[#002045]" x-text="activeDetail.status"></p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-[#43474E] uppercase">Keluhan Awal</p>
                                    <div class="bg-[#F9F9FF] p-3 rounded border border-[#E1E6F3] mt-1">
                                        <p class="text-sm text-[#111C2C]" x-text="activeDetail.keluhan"></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-[#C4C6CF]">
                    <button type="button" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-[#002045] text-base font-medium text-white hover:bg-[#001530] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#002045] sm:ml-3 sm:w-auto sm:text-sm" @click="showDetail = false; tab = 'pesan'">
                        Mulai Chat Konselor
                    </button>
                    <button type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-[#C4C6CF] shadow-sm px-4 py-2 bg-white text-base font-medium text-[#43474E] hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm" @click="showDetail = false">
                        Tutup
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function submitNewSession(event) {
        event.preventDefault();
        const form = event.target;
        const btn = form.querySelector('button[type=submit]');
        const originalText = btn.innerHTML;
        
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Memproses...';
        btn.disabled = true;
        
        let fd = new FormData(form);
        fetch('{{ url("user/chat/create") }}', {
            method: 'POST',
            body: fd,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'success') {
                window.location.reload();
            } else {
                alert('Gagal menjadwalkan sesi. Silakan coba lagi.');
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        })
        .catch(err => {
            console.error(err);
            btn.innerHTML = originalText;
            btn.disabled = false;
        });
    }
</script>
<script>
    function profileDashboard() {
        return {
            tab: 'ringkasan',
            activeChat: null,
            activePsikolog: '',
            activeRoom: null,
            messages: [],
            pollInterval: null,
            pollGlobal: null,
            roomUnreads: @json($room_unreads ?? (object)[]),
            get totalUnread() {
                let sum = 0;
                for (const key in this.roomUnreads) {
                    sum += parseInt(this.roomUnreads[key]) || 0;
                }
                return sum;
            },
            init() {
                this.pollGlobal = setInterval(() => {
                    this.checkUnread();
                }, 5000);
            },
            checkUnread() {
                fetch('{{ url("user/chat/unread") }}', {headers: {'X-Requested-With': 'XMLHttpRequest'}})
                .then(r => r.json())
                .then(data => {
                    if (data.status === 'success') {
                        const oldActiveUnread = this.activeChat ? (this.roomUnreads[this.activeChat] || 0) : 0;
                        this.roomUnreads = data.unreads;
                        const newActiveUnread = this.activeChat ? (this.roomUnreads[this.activeChat] || 0) : 0;
                        
                        // If active chat got a new unread message, auto fetch
                        if (this.activeChat && newActiveUnread > 0) {
                            this.fetchMessages();
                        }
                    }
                });
            },
            initChat(roomId, psikolog) {
                this.activeChat = roomId;
                this.activePsikolog = psikolog;
                this.fetchMessages();
                if(this.pollInterval) clearInterval(this.pollInterval);
                this.pollInterval = setInterval(() => this.fetchMessages(), 3000);
            },
            closeChat() {
                this.activeChat = null;
                if(this.pollInterval) clearInterval(this.pollInterval);
            },
            fetchMessages() {
                if(!this.activeChat) return;
                fetch('{{ url("user/chat/messages") }}?id_konsul=' + this.activeChat, {
                    headers: {'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json'}
                })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        const box = document.getElementById('chat-messages-container');
                        let isAtBottom = true;
                        if(box) isAtBottom = (box.scrollHeight - box.scrollTop <= box.clientHeight + 100);
                        this.messages = data.messages;
                        this.activeRoom = data.room;
                        
                        // Mark as read locally
                        if (this.roomUnreads[this.activeChat]) {
                            this.roomUnreads[this.activeChat] = 0;
                        }

                        this.$nextTick(() => {
                            if (box && isAtBottom) {
                                box.scrollTop = box.scrollHeight;
                            }
                        });
                    }
                });
            },
            sendMessage() {
                const input = document.getElementById('chat-input');
                const text = input.value.trim();
                if(!text) return;
                input.value = '';
                
                const fd = new FormData();
                fd.append('id_konsul', this.activeChat);
                fd.append('message', text);
                fd.append('_token', '{{ csrf_token() }}');
                
                fetch('{{ url("user/chat/send") }}', { method: 'POST', body: fd, headers: {'X-Requested-With': 'XMLHttpRequest'} })
                .then(() => this.fetchMessages());
            }
        }
    }
</script>
@endsection

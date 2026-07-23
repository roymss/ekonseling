<!-- Psikolog Kami Card -->
<div class="mb-8">
    <div class="flex items-center justify-between mb-4 pb-2 border-b-2 border-emerald-600">
        <h3 class="text-base font-extrabold text-slate-900 uppercase tracking-wide flex items-center">
            <i class="fa-solid fa-user-doctor text-emerald-600 mr-2.5"></i> Psikolog Kami
        </h3>
        <span class="text-[10px] font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">Aktif</span>
    </div>
    
    @php
        $users = \Illuminate\Support\Facades\DB::select("SELECT * FROM users where level='user' ORDER BY username DESC LIMIT 5");
    @endphp
    
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden divide-y divide-slate-100">
        @foreach ($users as $index => $row)
            @php
                $foto = (isset($row->foto) && trim($row->foto) != '') ? $row->foto : 'users.gif';
            @endphp
            <div class="p-3.5 flex items-center space-x-3.5 hover:bg-emerald-50/50 transition-colors group">
                <div class="relative flex-shrink-0">
                    <img src="{{ url('asset/foto_user/' . $foto) }}" alt="{{ $row->nama_lengkap ?? '' }}" class="w-11 h-11 rounded-full object-cover border-2 border-emerald-100 shadow-sm group-hover:scale-105 transition-transform">
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 border-2 border-white rounded-full"></span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-xs font-bold text-slate-900 capitalize truncate group-hover:text-emerald-600 transition-colors">{{ $row->nama_lengkap ?? 'Tanpa Nama' }}</h4>
                    <p class="text-[11px] text-slate-500 font-medium truncate mt-0.5"><i class="fa-solid fa-building-user text-emerald-600/70 mr-1 text-[10px]"></i>{{ $row->perangkat_daerah ?? '-' }}</p>
                    <p class="text-[10px] text-slate-400 truncate mt-0.5">{{ $row->email ?? '-' }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Tabs (AlpineJS) -->
<div x-data="{ activeTab: 'utama' }" class="bg-slate-900 rounded-2xl shadow-xl border border-slate-800 overflow-hidden hidden md:block">
    <div class="flex bg-slate-950 p-1.5 gap-1 border-b border-slate-800">
        <button @click="activeTab = 'utama'" :class="{ 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-md shadow-emerald-900/30': activeTab === 'utama', 'text-slate-400 hover:text-slate-200': activeTab !== 'utama' }" class="flex-1 py-2 rounded-xl text-[11px] font-semibold tracking-wider uppercase transition-all duration-200">UTAMA</button>
        <button @click="activeTab = 'pilihan'" :class="{ 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-md shadow-emerald-900/30': activeTab === 'pilihan', 'text-slate-400 hover:text-slate-200': activeTab !== 'pilihan' }" class="flex-1 py-2 rounded-xl text-[11px] font-semibold tracking-wider uppercase transition-all duration-200">PILIHAN</button>
        <button @click="activeTab = 'populer'" :class="{ 'bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold shadow-md shadow-emerald-900/30': activeTab === 'populer', 'text-slate-400 hover:text-slate-200': activeTab !== 'populer' }" class="flex-1 py-2 rounded-xl text-[11px] font-semibold tracking-wider uppercase transition-all duration-200">POPULER</button>
    </div>

    <div class="p-4">
        <!-- Tab: Utama -->
        <div x-show="activeTab === 'utama'" class="space-y-3.5">
            @php 
                $utama = \Illuminate\Support\Facades\DB::table('berita')
                            ->join('users', 'berita.username', '=', 'users.username')
                            ->join('kategori', 'berita.id_kategori', '=', 'kategori.id_kategori')
                            ->where(['status' => 'Y', 'utama' => 'Y'])
                            ->orderBy('id_berita', 'DESC')
                            ->skip(0)->take(8)->get();
            @endphp
            @foreach ($utama as $index => $row)
                <div class="flex items-start space-x-3 group">
                    <div class="flex-shrink-0 text-xl font-extrabold text-emerald-500/40 group-hover:text-emerald-400 transition-all w-6 text-center leading-none mt-0.5">
                        0{{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] text-slate-400 mb-1 flex items-center"><i class="fa-regular fa-clock text-emerald-400 mr-1 text-[9px]"></i> {{ $row->hari ?? '' }}, {{ tgl_indo($row->tanggal ?? date('Y-m-d')) }}</p>
                        <h5 class="text-xs font-semibold text-slate-200 leading-snug hover:text-emerald-400 transition-colors line-clamp-2">
                            <a href="{{ url('berita/detail/' . ($row->judul_seo ?? '')) }}" title="{{ $row->judul ?? '' }}">{{ $row->judul ?? '' }}</a>
                        </h5>
                    </div>
                </div>
                @if(!$loop->last)
                    <div class="border-b border-slate-800/80 my-2"></div>
                @endif
            @endforeach
        </div>

        <!-- Tab: Pilihan -->
        <div x-show="activeTab === 'pilihan'" style="display: none;" class="space-y-3.5">
            @php 
                $pilihan = \Illuminate\Support\Facades\DB::table('berita')
                            ->join('users', 'berita.username', '=', 'users.username')
                            ->join('kategori', 'berita.id_kategori', '=', 'kategori.id_kategori')
                            ->where(['status' => 'Y', 'berita.aktif' => 'Y'])
                            ->orderBy('id_berita', 'DESC')
                            ->skip(0)->take(8)->get();
            @endphp
            @foreach ($pilihan as $index => $row)
                <div class="flex items-start space-x-3 group">
                    <div class="flex-shrink-0 text-xl font-extrabold text-emerald-500/40 group-hover:text-emerald-400 transition-all w-6 text-center leading-none mt-0.5">
                        0{{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] text-slate-400 mb-1 flex items-center"><i class="fa-regular fa-clock text-emerald-400 mr-1 text-[9px]"></i> {{ $row->hari ?? '' }}, {{ tgl_indo($row->tanggal ?? date('Y-m-d')) }}</p>
                        <h5 class="text-xs font-semibold text-slate-200 leading-snug hover:text-emerald-400 transition-colors line-clamp-2">
                            <a href="{{ url('berita/detail/' . ($row->judul_seo ?? '')) }}" title="{{ $row->judul ?? '' }}">{{ $row->judul ?? '' }}</a>
                        </h5>
                    </div>
                </div>
                @if(!$loop->last)
                    <div class="border-b border-slate-800/80 my-2"></div>
                @endif
            @endforeach
        </div>

        <!-- Tab: Populer -->
        <div x-show="activeTab === 'populer'" style="display: none;" class="space-y-3.5">
            @php 
                $populer = \Illuminate\Support\Facades\DB::table('berita')
                            ->join('users', 'berita.username', '=', 'users.username')
                            ->join('kategori', 'berita.id_kategori', '=', 'kategori.id_kategori')
                            ->where(['status' => 'Y'])
                            ->orderBy('dibaca', 'DESC')
                            ->skip(0)->take(8)->get();
            @endphp
            @foreach ($populer as $index => $row)
                <div class="flex items-start space-x-3 group">
                    <div class="flex-shrink-0 text-xl font-extrabold text-emerald-500/40 group-hover:text-emerald-400 transition-all w-6 text-center leading-none mt-0.5">
                        0{{ $index + 1 }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-[10px] text-slate-400 mb-1 flex items-center"><i class="fa-regular fa-clock text-emerald-400 mr-1 text-[9px]"></i> {{ $row->hari ?? '' }}, {{ tgl_indo($row->tanggal ?? date('Y-m-d')) }}</p>
                        <h5 class="text-xs font-semibold text-slate-200 leading-snug hover:text-emerald-400 transition-colors line-clamp-2">
                            <a href="{{ url('berita/detail/' . ($row->judul_seo ?? '')) }}" title="{{ $row->judul ?? '' }}">{{ $row->judul ?? '' }}</a>
                        </h5>
                    </div>
                </div>
                @if(!$loop->last)
                    <div class="border-b border-slate-800/80 my-2"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>






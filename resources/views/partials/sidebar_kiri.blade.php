<div class="mb-8">
    <div class="border-b-2 border-green-600 mb-4 pb-2">
        <h3 class="text-lg font-bold text-gray-800 uppercase tracking-wide">
            <i class="fa-solid fa-user-doctor text-green-600 mr-2"></i> Psikolog Kami
        </h3>
    </div>
    
    @php
        $users = \Illuminate\Support\Facades\DB::select("SELECT * FROM users where level='user' ORDER BY username DESC LIMIT 5");
    @endphp
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden divide-y divide-gray-100">
        @foreach ($users as $index => $row)
            @php
                $foto = (isset($row->foto) && trim($row->foto) != '') ? $row->foto : 'users.gif';
                $bgClass = ($index % 2 == 0) ? 'bg-gray-50' : 'bg-white';
            @endphp
            <div class="{{ $bgClass }} p-3 flex items-start space-x-3 hover:bg-green-50 transition-colors">
                <img src="{{ url('asset/foto_user/' . $foto) }}" alt="{{ $row->nama_lengkap ?? '' }}" class="w-12 h-12 rounded-full object-cover border border-gray-200 shadow-sm flex-shrink-0">
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-bold text-gray-900 capitalize truncate">{{ $row->nama_lengkap ?? 'Tanpa Nama' }}</h4>
                    <p class="text-xs text-gray-600 font-medium truncate mt-0.5">{{ $row->perangkat_daerah ?? '-' }}</p>
                    <p class="text-[11px] text-gray-500 truncate mt-0.5">{{ $row->email ?? '-' }}</p>
                </div>
            </div>
        @endforeach
    </div>
</div>

<!-- Tabs (AlpineJS) -->
<div x-data="{ activeTab: 'utama' }" class="bg-gray-900 rounded-xl shadow-sm overflow-hidden hidden md:block">
    <div class="flex bg-white border-b border-gray-200">
        <button @click="activeTab = 'utama'" :class="{ 'bg-green-600 text-white font-bold': activeTab === 'utama', 'bg-white text-gray-600 hover:text-gray-900': activeTab !== 'utama' }" class="flex-1 py-3 text-xs tracking-wider uppercase transition-colors">UTAMA</button>
        <button @click="activeTab = 'pilihan'" :class="{ 'bg-green-600 text-white font-bold': activeTab === 'pilihan', 'bg-white text-gray-600 hover:text-gray-900': activeTab !== 'pilihan' }" class="flex-1 py-3 text-xs tracking-wider uppercase transition-colors border-l border-r border-gray-200">PILIHAN</button>
        <button @click="activeTab = 'populer'" :class="{ 'bg-green-600 text-white font-bold': activeTab === 'populer', 'bg-white text-gray-600 hover:text-gray-900': activeTab !== 'populer' }" class="flex-1 py-3 text-xs tracking-wider uppercase transition-colors">POPULER</button>
    </div>

    <div class="p-4">
        <!-- Tab: Utama -->
        <div x-show="activeTab === 'utama'" class="space-y-4">
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
                    <div class="flex-shrink-0 text-3xl font-black text-gray-700 opacity-30 group-hover:text-green-500 group-hover:opacity-100 transition-all w-8 text-center leading-none">
                        {{ $index + 1 }}
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 mb-1"><i class="fa-regular fa-clock mr-1"></i> {{ $row->hari ?? '' }}, {{ tgl_indo($row->tanggal ?? date('Y-m-d')) }}</p>
                        <h5 class="text-sm font-semibold text-white leading-tight hover:text-green-400 transition-colors line-clamp-2">
                            <a href="{{ url('berita/detail/' . ($row->judul_seo ?? '')) }}" title="{{ $row->judul ?? '' }}">{{ $row->judul ?? '' }}</a>
                        </h5>
                    </div>
                </div>
                @if(!$loop->last)
                    <div class="border-b border-gray-700 border-dotted my-2"></div>
                @endif
            @endforeach
        </div>

        <!-- Tab: Pilihan -->
        <div x-show="activeTab === 'pilihan'" style="display: none;" class="space-y-4">
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
                    <div class="flex-shrink-0 text-3xl font-black text-gray-700 opacity-30 group-hover:text-green-500 group-hover:opacity-100 transition-all w-8 text-center leading-none">
                        {{ $index + 1 }}
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 mb-1"><i class="fa-regular fa-clock mr-1"></i> {{ $row->hari ?? '' }}, {{ tgl_indo($row->tanggal ?? date('Y-m-d')) }}</p>
                        <h5 class="text-sm font-semibold text-white leading-tight hover:text-green-400 transition-colors line-clamp-2">
                            <a href="{{ url('berita/detail/' . ($row->judul_seo ?? '')) }}" title="{{ $row->judul ?? '' }}">{{ $row->judul ?? '' }}</a>
                        </h5>
                    </div>
                </div>
                @if(!$loop->last)
                    <div class="border-b border-gray-700 border-dotted my-2"></div>
                @endif
            @endforeach
        </div>

        <!-- Tab: Populer -->
        <div x-show="activeTab === 'populer'" style="display: none;" class="space-y-4">
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
                    <div class="flex-shrink-0 text-3xl font-black text-gray-700 opacity-30 group-hover:text-green-500 group-hover:opacity-100 transition-all w-8 text-center leading-none">
                        {{ $index + 1 }}
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 mb-1"><i class="fa-regular fa-clock mr-1"></i> {{ $row->hari ?? '' }}, {{ tgl_indo($row->tanggal ?? date('Y-m-d')) }}</p>
                        <h5 class="text-sm font-semibold text-white leading-tight hover:text-green-400 transition-colors line-clamp-2">
                            <a href="{{ url('berita/detail/' . ($row->judul_seo ?? '')) }}" title="{{ $row->judul ?? '' }}">{{ $row->judul ?? '' }}</a>
                        </h5>
                    </div>
                </div>
                @if(!$loop->last)
                    <div class="border-b border-gray-700 border-dotted my-2"></div>
                @endif
            @endforeach
        </div>
    </div>
</div>





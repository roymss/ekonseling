<div class="container mx-auto px-4">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
        
        <!-- Kolom 1: User Login / Profile -->
        <div>
            <h3 class="text-lg font-bold mb-4 flex items-center border-b border-slate-800 pb-3 text-white tracking-wide">
                <span class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-sm mr-2.5"><i class="fa-solid fa-user-gear"></i></span> User Area
            </h3>
            
            <?php 
            $usr = \Illuminate\Support\Facades\DB::table('users')->where('username', session('username'))->first();
            if ($usr && session('level')!='admin'){
                $foto_user = trim($usr->foto) == '' ? 'users.gif' : $usr->foto; 
                $tentang = strip_tags($usr->alamat_lengkap); 
            ?>
                <div class="bg-slate-800/80 border border-slate-700/60 rounded-2xl p-5 flex gap-4 backdrop-blur-sm">
                    <div class="flex-shrink-0 text-center">
                        <img class="w-16 h-16 rounded-full object-cover border-2 border-emerald-500 shadow-md" src="{{ url('/') }}/asset/foto_user/{{ $foto_user }}" alt="Foto Profile">
                        <div class="text-[10px] text-emerald-400 font-bold mt-2 uppercase bg-emerald-950/60 px-2 py-0.5 rounded-full border border-emerald-800/50">{{ $usr->level }}</div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <a href="{{ url('user/profile') }}" class="font-bold text-white hover:text-emerald-400 transition-colors text-sm truncate block">{{ $usr->nama_lengkap }}</a>
                        <div class="text-xs text-emerald-400 mb-2 truncate">{{ $usr->email }}</div>
                        <div class="border-t border-slate-700/80 pt-2 text-xs text-slate-300 space-y-1.5">
                            <div class="flex items-center"><i class="fa-solid fa-venus-mars w-4 text-slate-400"></i> {{ $usr->jenis_kelamin }}</div>
                            <div class="flex items-center"><i class="fa-solid fa-phone w-4 text-slate-400"></i> {{ $usr->no_telp }}</div>
                            <div class="truncate flex items-center"><i class="fa-solid fa-map-marker-alt w-4 text-slate-400"></i> {{ $tentang }}</div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                @if(session('message'))
                    <div class="bg-emerald-900/40 border-l-4 border-emerald-500 text-emerald-200 p-3 text-xs mb-4 rounded-r-xl">
                        {!! session('message') !!}
                    </div>
                @endif
                <form action="{{ url('user/login') }}" method="POST" class="space-y-3.5 bg-slate-800/80 border border-slate-700/60 p-5 rounded-2xl shadow-xl backdrop-blur-sm" onSubmit="return validasireg(this)">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">Username / Email</label>
                        <input type="text" name='a' class="w-full px-3.5 py-2 bg-slate-900/90 border border-slate-700 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all placeholder:text-slate-500" placeholder="Username / Email Anda">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-300 mb-1.5 uppercase tracking-wider">Password</label>
                        <input type="password" name='b' class="w-full px-3.5 py-2 bg-slate-900/90 border border-slate-700 rounded-xl text-white text-xs focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-500/20 transition-all placeholder:text-slate-500" placeholder="Password">
                    </div>
                    <div class="pt-1 flex space-x-3">
                        <button type="submit" name='submit' class="flex-1 bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-500 hover:to-teal-500 text-white font-bold py-2.5 px-4 rounded-xl transition-all text-xs shadow-md shadow-emerald-900/30">
                            Sign In
                        </button>
                        <a href="{{ url('user/pendaftaran') }}" class="flex-1 bg-slate-700 hover:bg-slate-600 text-white font-semibold py-2.5 px-4 rounded-xl transition-all text-xs text-center border border-slate-600">
                            Daftar
                        </a>
                    </div>
                </form>
            <?php } ?>
        </div>

        <!-- Kolom 2: Kategori -->
        <div>
            <h3 class="text-lg font-bold mb-4 flex items-center border-b border-slate-800 pb-3 text-white tracking-wide">
                <span class="w-8 h-8 rounded-xl bg-teal-500/20 text-teal-400 flex items-center justify-center text-sm mr-2.5"><i class="fa-solid fa-folder-open"></i></span> Kategori Artikel
            </h3>
            <ul class="space-y-2.5">
            <?php 
                $kategori = \Illuminate\Support\Facades\DB::table('kategori')->orderBy('id_kategori', 'DESC')->skip(0)->take(5)->get();
                foreach ($kategori as $r) {	
                    echo "<li class='border-b border-slate-800/80 pb-2.5'><a href='".url('kategori/detail/'.$r->kategori_seo)."' class='text-slate-300 hover:text-emerald-400 transition-colors flex items-center text-xs font-medium group'><i class='fa-solid fa-chevron-right text-[10px] mr-2.5 text-emerald-500 group-hover:translate-x-1 transition-transform'></i> $r->nama_kategori</a></li>";
                }
            ?>
            </ul>
        </div>
        
        <!-- Kolom 3: Unduh Dokumen -->
        <div>
            <h3 class="text-lg font-bold mb-4 flex items-center border-b border-slate-800 pb-3 text-white tracking-wide">
                <span class="w-8 h-8 rounded-xl bg-emerald-500/20 text-emerald-400 flex items-center justify-center text-sm mr-2.5"><i class="fa-solid fa-cloud-arrow-down"></i></span> Unduh Dokumen
            </h3>
            <ul class="space-y-2.5">
            <?php 
                $download = \Illuminate\Support\Facades\DB::table('download')->orderBy('id_download', 'DESC')->skip(0)->take(5)->get();
                foreach ($download as $r) {	
                    echo "<li class='border-b border-slate-800/80 pb-2.5'><a href='".url('download/file/'.$r->nama_file)."' class='text-slate-300 hover:text-emerald-400 transition-colors flex items-center text-xs font-medium truncate group' title='$r->judul'><i class='fa-solid fa-file-pdf text-[12px] mr-2.5 text-rose-400 group-hover:scale-110 transition-transform'></i> <span class='truncate'>$r->judul</span></a></li>";
                }
            ?>
            </ul>
        </div>
    </div>
</div>
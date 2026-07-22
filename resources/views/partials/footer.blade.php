<div class="container mx-auto px-4">
    <div class="border-t border-gray-800 mb-8 pt-8"></div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- Kolom 1: User Login / Profile -->
        <div>
            <h3 class="text-xl font-bold mb-4 flex items-center border-b border-gray-800 pb-2">
                <span class="text-green-400 mr-2"><i class="fa-solid fa-user"></i></span> User Area
            </h3>
            
            <?php 
            $usr = \Illuminate\Support\Facades\DB::table('users')->where('username', session('username'))->first();
            if ($usr && session('level')!='admin'){
                $foto_user = trim($usr->foto) == '' ? 'users.gif' : $usr->foto; 
                $tentang = strip_tags($usr->alamat_lengkap); 
            ?>
                <div class="bg-gray-800 rounded-lg p-4 flex gap-4">
                    <div class="flex-shrink-0 text-center">
                        <img class="w-16 h-16 rounded-full object-cover border-2 border-green-500" src="{{ url('/') }}/asset/foto_user/{{ $foto_user }}" alt="Foto Profile">
                        <div class="text-xs text-gray-400 mt-2 uppercase">{{ $usr->level }}</div>
                    </div>
                    <div>
                        <a href="{{ url('user/profile') }}" class="font-bold text-white hover:text-green-400">{{ $usr->nama_lengkap }}</a>
                        <div class="text-xs text-red-400 mb-2">{{ $usr->email }}</div>
                        <div class="border-t border-gray-700 pt-2 text-xs text-gray-300 space-y-1">
                            <div><i class="fa-solid fa-venus-mars w-4"></i> {{ $usr->jenis_kelamin }}</div>
                            <div><i class="fa-solid fa-phone w-4"></i> {{ $usr->no_telp }}</div>
                            <div class="truncate"><i class="fa-solid fa-map-marker-alt w-4"></i> {{ $tentang }}</div>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                @if(session('message'))
                    <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-3 text-sm mb-4">
                        {!! session('message') !!}
                    </div>
                @endif
                <form action="{{ url('user/login') }}" method="POST" class="space-y-4 bg-gray-800 p-5 rounded-lg" onSubmit="return validasireg(this)">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Username / Email</label>
                        <input type="text" name='a' class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500" placeholder="Username/Email">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                        <input type="password" name='b' class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500" placeholder="Password">
                    </div>
                    <div class="pt-2 flex space-x-3">
                        <button type="submit" name='submit' class="flex-1 bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm">
                            Sign in
                        </button>
                        <a href="{{ url('user/pendaftaran') }}" class="flex-1 bg-gray-700 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm text-center">
                            Daftar
                        </a>
                    </div>
                </form>
            <?php } ?>
        </div>

        <!-- Kolom 2: Kategori -->
        <div>
            <h3 class="text-xl font-bold mb-4 flex items-center border-b border-gray-800 pb-2">
                <span class="text-green-400 mr-2"><i class="fa-solid fa-folder-open"></i></span> Kategori
            </h3>
            <ul class="space-y-2">
            <?php 
                $kategori = \Illuminate\Support\Facades\DB::table('kategori')->orderBy('id_kategori', 'DESC')->skip(0)->take(5)->get();
                foreach ($kategori as $r) {	
                    echo "<li class='border-b border-gray-800 pb-2'><a href='".url('kategori/detail/'.$r->kategori_seo)."' class='text-gray-300 hover:text-green-400 transition-colors block'><i class='fa-solid fa-angle-right text-xs mr-2 text-gray-500'></i> $r->nama_kategori</a></li>";
                }
            ?>
            </ul>
        </div>
        
        <!-- Kolom 3: Unduh Dokumen -->
        <div>
            <h3 class="text-xl font-bold mb-4 flex items-center border-b border-gray-800 pb-2">
                <span class="text-green-400 mr-2"><i class="fa-solid fa-download"></i></span> Unduh Dokumen
            </h3>
            <ul class="space-y-2">
            <?php 
                $download = \Illuminate\Support\Facades\DB::table('download')->orderBy('id_download', 'DESC')->skip(0)->take(5)->get();
                foreach ($download as $r) {	
                    echo "<li class='border-b border-gray-800 pb-2'><a href='".url('download/file/'.$r->nama_file)."' class='text-gray-300 hover:text-green-400 transition-colors block truncate' title='$r->judul'><i class='fa-solid fa-file-pdf text-xs mr-2 text-gray-500'></i> $r->judul</a></li>";
                }
            ?>
            </ul>
        </div>
    </div>
</div>
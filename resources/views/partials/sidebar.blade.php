@php 
$usr = \Illuminate\Support\Facades\DB::table('users')->where('username', session('username'))->first();
@endphp

@if ($usr && request()->segment(1) == 'user')
    @php
        $foto_user = trim($usr->foto ?? '') == '' ? 'users.gif' : $usr->foto;
        $tentang = strip_tags($usr->alamat_lengkap ?? '');
    @endphp

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="bg-green-600 text-white text-center py-3 font-semibold text-sm">
            Profil Inovator
        </div>
        <div class="p-5">
            <div class="flex items-start space-x-4 mb-4 pb-4 border-b border-gray-100">
                <div class="flex-shrink-0 flex flex-col items-center">
                    <img src="{{ url('asset/foto_user/' . $foto_user) }}" alt="{{ $usr->nama_lengkap ?? '' }}" class="w-16 h-16 rounded-full object-cover border-2 border-green-100 shadow-sm">
                    <span class="text-[10px] text-gray-500 font-medium uppercase mt-2 bg-gray-100 px-2 py-0.5 rounded-full">(Inovator)</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-bold text-gray-900 truncate">{{ $usr->nama_lengkap ?? '' }}</h4>
                    <p class="text-xs text-red-500 truncate mb-2">{{ $usr->email ?? '' }}</p>
                    
                    <div class="text-xs text-gray-600 space-y-1">
                        <p class="flex items-center"><i class="fa-solid fa-venus-mars w-4 text-gray-400"></i> {{ $usr->jenis_kelamin ?? '-' }}</p>
                        <p class="flex items-center"><i class="fa-solid fa-phone w-4 text-gray-400"></i> {{ $usr->no_telp ?? '-' }}</p>
                    </div>
                </div>
            </div>
            
            @if($tentang)
            <div class="mb-4 text-xs text-gray-500 leading-relaxed italic line-clamp-2">
                "{{ $tentang }}"
            </div>
            @endif

            <div class="space-y-2">
                <button type="button" x-data @click="$dispatch('open-upload-modal')" class="w-full block text-center bg-blue-50 hover:bg-blue-100 text-blue-700 font-medium py-1.5 px-3 rounded-md transition-colors text-xs border border-blue-200 shadow-sm">
                    <i class="fa-solid fa-camera mr-1"></i> Ganti Foto
                </button>
                <a href="{{ url('user/profile') }}" class="w-full block text-center bg-green-500 hover:bg-green-600 text-white font-medium py-1.5 px-3 rounded-md transition-colors text-xs shadow-sm">
                    <i class="fa-solid fa-user mr-1"></i> View Profile
                </a>
                <a href="{{ url('user/konsultasi') }}" class="w-full block text-center bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-1.5 px-3 rounded-md transition-colors text-xs shadow-sm">
                    <i class="fa-solid fa-list mr-1"></i> List/Data Konsultasi
                </a>
            </div>
        </div>
    </div>
@endif

@php
  $pasangiklan2 = \Illuminate\Support\Facades\DB::table('pasangiklan')->orderBy('id_pasangiklan', 'DESC')->skip(0)->take(1)->get();
@endphp

@foreach ($pasangiklan2 as $b)
    @if ($b->gambar != '')
        <div class="rounded-xl overflow-hidden shadow-sm hover:shadow-md transition-shadow border border-gray-100 mt-6">
            <a href="{{ $b->url ?? '#' }}">
                <img src="{{ url('asset/foto_pasangiklan/' . $b->gambar) }}" class="w-full h-auto" alt="Iklan">
            </a>
        </div>
    @endif
@endforeach

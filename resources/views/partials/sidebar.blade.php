@php 
$usr = \Illuminate\Support\Facades\DB::table('users')->where('username', session('username'))->first();
@endphp

@if ($usr && request()->segment(1) == 'user')
    @php
        $foto_user = trim($usr->foto ?? '') == '' ? 'users.gif' : $usr->foto;
        $tentang = strip_tags($usr->alamat_lengkap ?? '');
    @endphp

    @if(session('message'))
        <div class="mb-4">
            {!! session('message') !!}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200/80 overflow-hidden mb-6">
        <div class="bg-gradient-to-r from-emerald-700 to-teal-700 text-white text-center py-3 font-bold text-xs uppercase tracking-wider">
            Profil {{ ucfirst($usr->level ?? 'Inovator') }}
        </div>
        <div class="p-5">
            <div class="flex items-start space-x-4 mb-4 pb-4 border-b border-slate-100">
                <div class="flex-shrink-0 flex flex-col items-center">
                    <img src="{{ url('asset/foto_user/' . $foto_user) }}" alt="{{ $usr->nama_lengkap ?? '' }}" class="w-16 h-16 rounded-full object-cover border-2 border-emerald-500/30 shadow-md">
                    <span class="text-[10px] text-emerald-700 font-bold uppercase mt-2 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">({{ ucfirst($usr->level ?? 'Inovator') }})</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-bold text-slate-900 truncate">{{ $usr->nama_lengkap ?? '' }}</h4>
                    <p class="text-xs text-emerald-600 font-medium truncate mb-2">{{ $usr->email ?? '' }}</p>
                    
                    <div class="text-xs text-slate-600 space-y-1">
                        <p class="flex items-center"><i class="fa-solid fa-venus-mars w-4 text-slate-400"></i> {{ $usr->jenis_kelamin ?? '-' }}</p>
                        <p class="flex items-center"><i class="fa-solid fa-phone w-4 text-slate-400"></i> {{ $usr->no_telp ?? '-' }}</p>
                    </div>
                </div>
            </div>
            
            @if($tentang)
            <div class="mb-4 text-xs text-slate-500 leading-relaxed italic line-clamp-2 bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                "{{ $tentang }}"
            </div>
            @endif

            <div class="space-y-2">
                <button type="button" x-data @click="$dispatch('open-upload-modal')" class="w-full block text-center bg-teal-50 hover:bg-teal-100 text-teal-700 font-semibold py-2 px-3 rounded-xl transition-all text-xs border border-teal-200 shadow-sm">
                    <i class="fa-solid fa-camera mr-1"></i> Ganti Foto Profil
                </button>
                <a href="{{ url('user/profile') }}" class="w-full block text-center bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-3 rounded-xl transition-all text-xs shadow-md shadow-emerald-600/20">
                    <i class="fa-solid fa-user mr-1"></i> View Profile
                </a>
                <a href="{{ url('user/konsultasi') }}" class="w-full block text-center bg-amber-500 hover:bg-amber-600 text-slate-950 font-bold py-2 px-3 rounded-xl transition-all text-xs shadow-md shadow-amber-500/20">
                    <i class="fa-solid fa-list mr-1"></i> Data Konsultasi
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
        <div class="rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow border border-slate-200/80 mt-6">
            <a href="{{ $b->url ?? '#' }}">
                <img src="{{ url('asset/foto_pasangiklan/' . $b->gambar) }}" class="w-full h-auto" alt="Iklan">
            </a>
        </div>
    @endif
@endforeach


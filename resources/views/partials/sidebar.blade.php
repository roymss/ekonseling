@php 
$usr = \Illuminate\Support\Facades\DB::table('users')->where('username', session('username'))->first();
@endphp

@if ($usr && request()->segment(1) == 'user')
    @php
        $foto_user = trim($usr->foto ?? '') == '' ? 'users.gif' : $usr->foto;
        $tentang = strip_tags($usr->alamat_lengkap ?? '');
    @endphp

    @if(session('message'))
        <div class="mb-4 text-sm text-[#BA1A1A] bg-[#FFDAD6] border border-[#BA1A1A]/20 p-3 rounded-lg shadow-sm">
            {!! session('message') !!}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-[#C4C6CF] overflow-hidden mb-6 font-['Inter']">
        <div class="bg-[#002045] text-white text-center py-3 font-bold text-xs uppercase tracking-wider">
            Profil {{ ucfirst($usr->level ?? 'Warga') }}
        </div>
        <div class="p-5">
            <div class="flex items-start space-x-4 mb-4 pb-4 border-b border-[#E1E6F3]">
                <div class="flex-shrink-0 flex flex-col items-center">
                    <img src="{{ url('asset/foto_user/' . $foto_user) }}" alt="{{ $usr->nama_lengkap ?? '' }}" class="w-16 h-16 rounded-full object-cover border border-[#C4C6CF] shadow-sm">
                    <span class="text-[10px] text-[#002045] font-bold uppercase mt-2 bg-[#E8F0FE] px-2 py-0.5 rounded-full border border-[#D8E3FA]">({{ ucfirst($usr->level ?? 'Warga') }})</span>
                </div>
                <div class="flex-1 min-w-0">
                    <h4 class="text-sm font-bold text-[#111C2C] truncate">{{ $usr->nama_lengkap ?? '' }}</h4>
                    <p class="text-xs text-[#43474E] font-medium truncate mb-2">{{ $usr->email ?? '' }}</p>
                    
                    <div class="text-xs text-[#43474E] space-y-1">
                        <p class="flex items-center"><i class="fa-solid fa-venus-mars w-4 text-[#C4C6CF]"></i> {{ $usr->jenis_kelamin ?? '-' }}</p>
                        <p class="flex items-center"><i class="fa-solid fa-phone w-4 text-[#C4C6CF]"></i> {{ $usr->no_telp ?? '-' }}</p>
                    </div>
                </div>
            </div>
            
            @if($tentang)
            <div class="mb-4 text-xs text-[#43474E] leading-relaxed italic line-clamp-2 bg-[#F9F9FF] p-2.5 rounded-xl border border-[#E1E6F3]">
                "{{ $tentang }}"
            </div>
            @endif

            <div class="space-y-2">
                <button type="button" x-data @click="$dispatch('open-upload-modal')" class="w-full block text-center bg-[#E8F0FE] hover:bg-[#D8E3FA] text-[#002045] font-semibold py-2.5 px-3 rounded-xl transition-all text-xs border border-[#C4C6CF] shadow-sm">
                    <i class="fa-solid fa-camera mr-1"></i> Ganti Foto Profil
                </button>
            </div>
        </div>
    </div>
@endif

@php
  $pasangiklan2 = \Illuminate\Support\Facades\DB::table('pasangiklan')->orderBy('id_pasangiklan', 'DESC')->skip(0)->take(1)->get();
@endphp

@foreach ($pasangiklan2 as $b)
    @if ($b->gambar != '')
        <div class="rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-shadow border border-[#C4C6CF] mt-6">
            <a href="{{ $b->url ?? '#' }}">
                <img src="{{ url('asset/foto_pasangiklan/' . $b->gambar) }}" class="w-full h-auto" alt="Iklan">
            </a>
        </div>
    @endif
@endforeach

@extends('layouts.app')
@section('content')
@php
	$total_komentar = \Illuminate\Support\Facades\DB::table('komentar_konsul')->where(['id_konsul' => $rows->id_konsul,'aktif'=>'Y'])->count();
@endphp	
<div class="max-w-4xl mx-auto mb-12">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 flex flex-wrap items-center gap-2">
        <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <span>Konsultasi</span> 
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <span class="text-gray-800 font-medium">{{ $rows->judul }}</span>
    </div>  
    
    <header class="mb-8 border-b border-gray-200 pb-6">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-900 leading-tight mb-3">
            {{ $rows->judul }}
        </h1>
        
        <div class="flex flex-wrap items-center justify-between text-sm text-gray-500 gap-4 uppercase font-medium">
            <div class="flex items-center gap-4">
                <span class="flex items-center"><i class="fa-regular fa-calendar text-green-500 mr-2"></i> {{ $rows->hari.', '.tgl_indo($rows->tanggal)." | ".$rows->jam." WIB" }}</span>
                <span class="flex items-center"><i class="fa-solid fa-user-pen text-green-500 mr-2"></i> Oleh {{ $rows->nama_lengkap }}</span>
            </div>
            <div class="flex items-center gap-2">
                @if (\Illuminate\Support\Facades\Auth::check())
                <button onclick="startVideoCall(false)" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1.5 rounded shadow-sm text-xs font-bold transition-colors">
                    <i class="fa-solid fa-video mr-1"></i> Mulai Video Call
                </button>
                <button onclick="startVideoCall(true)" class="bg-teal-600 hover:bg-teal-700 text-white px-3 py-1.5 rounded shadow-sm text-xs font-bold transition-colors">
                    <i class="fa-solid fa-phone mr-1"></i> Mulai Voice Call
                </button>
                @endif
                
                <!-- AddThis Button BEGIN -->
                <div class='addthis_toolbox addthis_default_style ml-4'>
                    <a class='addthis_button_preferred_1'></a>
                    <a class='addthis_button_preferred_2'></a>
                    <a class='addthis_button_preferred_3'></a>
                    <a class='addthis_button_preferred_4'></a>
                    <a class='addthis_button_compact'></a>
                    <a class='addthis_counter addthis_bubble_style'></a>
                </div>
                <script type='text/javascript' src='http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4f8aab4674f1896a'></script>
            </div>
        </div>
    </header>
  
	<article class="prose max-w-none prose-green prose-lg text-gray-800 leading-relaxed mb-10">
        {!! $rows->isi_konsul !!}
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class='fb-like' data-href="{{ url('konsultasi/detail/'.$rows->judul_seo) }}" data-send='false' data-width='600' data-show-faces='false'></div>
        </div>
	</article>	

    <!-- Jitsi Video Call Section -->
    <div class="bg-indigo-50 rounded-xl p-6 md:p-8 mb-8 border border-indigo-100 hidden" id="videoCallContainer">
        <h3 class="text-xl font-bold text-indigo-900 mb-4 flex items-center justify-between">
            <span><i class="fa-solid fa-video text-indigo-600 mr-3"></i> Sesi Call Langsung</span>
            <button onclick="document.getElementById('videoCallContainer').classList.add('hidden')" class="text-sm bg-red-100 text-red-600 hover:bg-red-200 px-3 py-1 rounded">Tutup Sesi</button>
        </h3>
        <div id="meet" class="w-full rounded-lg overflow-hidden border border-indigo-200 bg-gray-900" style="height: 500px;"></div>
    </div>

    <!-- Comments Section -->
    <div class="bg-gray-50 rounded-xl p-6 md:p-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-6 flex items-center">
            <i class="fa-regular fa-comments text-green-600 mr-3"></i> Komentar ({{ $total_komentar }})
        </h3>
        
        @if ($total_komentar >= 1)
            <div class="space-y-6 mb-10">
                @php
                if (session('level') != 'inovator') {
                    $komentar = \Illuminate\Support\Facades\DB::table('komentar_konsul')->where('id_konsul', $rows->id_konsul)->orderBy('id_komentar', 'ASC')->get();
                } else {
                    $komentar = \Illuminate\Support\Facades\DB::table('komentar_konsul')->where(['id_konsul' => $rows->id_konsul, 'aktif' => 'Y'])->orderBy('id_komentar', 'ASC')->get();
                }
                @endphp
                @foreach ($komentar as $kom)
                    @php
                    $isian = nl2br($kom->isi_komentar); 
                    $test = md5(strtolower(trim($kom->email))); 
                    $is_active = $kom->aktif == 'Y';
                    @endphp
                    <div class="flex gap-4 p-4 bg-white rounded-lg shadow-sm border border-gray-100">
                        <div class="flex-shrink-0">
                        @if ($kom->email == '')
                            <img class="w-12 h-12 rounded-full object-cover border border-gray-200" src="{{ url('asset/foto_user/blank.png') }}" alt="Avatar"/>
                        @else
                            <img class="w-12 h-12 rounded-full object-cover border border-gray-200" src="http://www.gravatar.com/avatar/{{ $test }}.jpg?s=100" alt="Avatar"/>
                        @endif
                        </div>
                        <div class="flex-grow">
                            <div class="flex flex-wrap items-center justify-between mb-1 gap-2">
                                <strong class="font-bold {{ $is_active ? 'text-gray-900' : 'text-orange-500' }}">
                                    {{ $kom->nama_komentar }} 
                                    @if(!$is_active) <span class="text-xs text-red-500 font-normal bg-red-50 px-2 py-0.5 rounded-full ml-1">(Non Aktif)</span> @endif
                                </strong>
                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-md">{{ tgl_indo($kom->tgl) }}, {{ $kom->jam_komentar }} WIB</span>
                            </div>
                            <div class="text-gray-700 mt-2 text-sm">
                                {!! $isian !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        @if (\Illuminate\Support\Facades\Auth::check())
            <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                <h4 class="text-lg font-bold text-gray-800 mb-4 border-b pb-2">Tinggalkan Komentar</h4>
                <form method="POST" action="{{ url('konsultasi/kirim_komentar') }}" class="space-y-4">
                    @csrf
                    <input type="hidden" name='a' value="{{ $rows->id_konsul }}">
                    <input type="hidden" name="c">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Isi Komentar</label>
                        <textarea name='d' rows="4" placeholder="Tuliskan Komentar disini.." class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Keamanan</label>
                            <div class="flex items-center gap-3">
                                <div class="bg-gray-100 p-2 rounded border border-gray-200">
                                    {!! $image !!}
                                </div>
                                <input name='secutity_code' maxlength='6' type='text' class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" placeholder="Masukkan kode..">
                            </div>
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" name="submit" class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-6 rounded-md transition-colors shadow-sm">
                            Kirim Komentar
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-md flex items-center justify-center">
                <i class="fa-solid fa-lock mr-2"></i>
                <span>Silahkan <a href="{{ url('user/login') }}" class="font-bold underline hover:text-green-600">Login</a> untuk Memberikan Komentar!</span>
            </div>
        @endif
    </div>
</div>

<script src='https://meet.jit.si/external_api.js'></script>
<script>
    let api = null;
    function startVideoCall(audioOnly = false) {
        document.getElementById('videoCallContainer').classList.remove('hidden');
        if (api) {
            api.dispose();
        }
        const domain = 'meet.jit.si';
        const options = {
            roomName: 'eKonseling-{{ $rows->judul_seo }}-{{ $rows->id_konsul }}',
            width: '100%',
            height: 500,
            parentNode: document.querySelector('#meet'),
            userInfo: {
                displayName: '{{ session("level") != "" ? (Auth::check() ? Auth::user()->nama_lengkap : session("username")) : "Tamu" }}'
            },
            configOverwrite: { 
                startWithAudioMuted: false,
                startWithVideoMuted: audioOnly
            },
            interfaceConfigOverwrite: {
                filmStripOnly: false
            }
        };
        api = new JitsiMeetExternalAPI(domain, options);
    }
</script>

@endsection

@extends('layouts.app')
@section('content')
<script type="text/javascript">
	function validasireg(form){
		if (form.a.value == ""){ alert("Anda belum mengisikan Nama"); form.a.focus(); return (false); }							
		if (form.b.value == ""){ alert("Anda belum mengisikan Email"); form.b.focus(); return (false); }									
		if (form.c.value == ""){ alert("Anda belum menuliskan Pesan"); form.c.focus(); return (false); }
		if (form.secutity_code.value == ""){ alert("Anda belum menuliskan Kode Keamanan"); form.secutity_code.focus(); return (false); }																		
	  return (true);
	}
</script>	

<div class="max-w-6xl mx-auto mb-12">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <span class="text-gray-800 font-medium">{{ $title }}</span>
    </div>

    <h2 class="text-3xl font-bold text-gray-900 mb-8 pb-3 border-b-2 border-green-600 inline-block">{{ $title }}</h2>
    
    <div class="w-full bg-gray-100 rounded-xl overflow-hidden shadow-sm mb-10 h-[350px]">
        <iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="{{ $iden->maps }}" class="border-0"></iframe> 		 
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
        <!-- Alamat / Info -->
        <div class="prose prose-green max-w-none text-gray-700 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2"><i class="fa-solid fa-map-location-dot text-green-600 mr-2"></i> Informasi Kontak</h3>
            {!! $rows->alamat !!}
        </div>

        <!-- Form Kontak -->
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-xl font-bold text-gray-900 mb-4 border-b pb-2"><i class="fa-solid fa-envelope-open-text text-green-600 mr-2"></i> Kirim Pesan</h3>
            
            @if (session('message'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm">
                    {{ session('message') }}
                </div>
            @endif

            <form action="{{ url('hubungi/kirim') }}" method="POST" id="form_komentar" onsubmit="return validasireg(this)" class="space-y-4">
                @csrf
                
                <div>
                    <label for="c_name" class="block text-sm font-medium text-gray-700 mb-1">Nama <span class="text-red-500">*</span></label>
                    <input type="text" name='a' id="c_name" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>
                
                <div>
                    <label for="c_email" class="block text-sm font-medium text-gray-700 mb-1">Surel / Email <span class="text-red-500">*</span></label>
                    <input type="email" name='b' id="c_email" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>
                
                <div>
                    <label for="c_message" class="block text-sm font-medium text-gray-700 mb-1">Pesan <span class="text-red-500">*</span></label>
                    <textarea name='c' id="c_message" required rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm"></textarea>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kode Keamanan <span class="text-red-500">*</span></label>
                    <div class="flex items-center gap-3">
                        <div class="bg-gray-100 p-2 rounded border border-gray-200">
                            {!! $image !!}
                        </div>
                        <input name='secutity_code' maxlength="6" type="text" required class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" placeholder="Masukkan kode di samping..">
                    </div>
                </div>
                
                <div class="pt-2">
                    <button type="submit" name="submit" class="w-full sm:w-auto bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-8 rounded-md transition-colors shadow-sm" onclick="return confirm('Pesan anda ini akan kami balas melalui email ?')">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Kirim Pesan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

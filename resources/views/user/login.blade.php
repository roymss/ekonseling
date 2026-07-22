@extends('layouts.app')
@section('content')
<script type="text/javascript">
	function validasilogin(form){
		if (form.a.value == ""){ alert("Anda belum mengisikan Username/Email"); form.a.focus(); return (false); }							
		if (form.b.value == ""){ alert("Anda belum mengisikan Password"); form.b.focus(); return (false); }																		
	  return (true);
	}
</script>	

<div class="max-w-4xl mx-auto mb-32">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <span class="text-gray-800 font-medium">{{ $title ?? 'Login' }}</span>
    </div>

    <div class="bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden max-w-xl mx-auto">
        <div class="bg-green-600 px-6 py-4">
            <h2 class="text-2xl font-bold text-white text-center">{{ $title ?? 'Login Area' }}</h2>
        </div>
        
        <div class="p-8">
            <div class="bg-blue-50 text-blue-800 border-l-4 border-blue-500 p-4 rounded-md mb-6 shadow-sm text-sm">
                <strong><i class="fa-solid fa-circle-info mr-2"></i> PENTING!</strong> Silahkan login dengan email dan password anda!
            </div>
            
            @if(session('message'))
                <div class="bg-red-50 text-red-700 border-l-4 border-red-500 p-4 rounded-md mb-6 shadow-sm">
                    {!! session('message') !!}
                </div>
            @endif

            <form action="{{ url('user/login') }}" method="POST" onsubmit="return validasilogin(this)" class="space-y-6">
                @csrf
                <div>
                    <label for="inputEmail3" class="block text-sm font-medium text-gray-700 mb-2">Username / Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-regular fa-envelope text-gray-400"></i>
                        </div>
                        <input type="text" name="a" id="inputEmail3" class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" placeholder="Masukkan Username atau Email">
                    </div>
                </div>
                
                <div>
                    <label for="inputPassword3" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="b" id="inputPassword3" class="pl-10 w-full px-4 py-2.5 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors" placeholder="Masukkan Password">
                    </div>
                </div>
                
                <div class="flex items-center justify-end">
                    <a href="#" class="text-sm font-medium text-green-600 hover:text-green-800 hover:underline transition-colors">Lupa Password?</a>
                </div>
                
                <div class="pt-4 flex flex-col sm:flex-row gap-3">
                    <button type="submit" name="submit" class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-4 rounded-lg shadow transition-colors flex items-center justify-center">
                        <i class="fa-solid fa-right-to-bracket mr-2"></i> Sign in
                    </button>
                    <a href="{{ url('user/pendaftaran') }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 px-4 rounded-lg shadow transition-colors flex items-center justify-center text-center">
                        <i class="fa-solid fa-user-plus mr-2"></i> Registrasi
                    </a>
                </div>
                
                <div class="mt-4 text-center">
                    <a href="{{ url('/') }}" class="text-sm text-gray-500 hover:text-gray-900 transition-colors"><i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Halaman Utama</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
<script type="text/javascript">
	function validasilogin(form){
		if (form.a.value == ""){ alert("Anda belum mengisikan Username/Email"); form.a.focus(); return (false); }							
		if (form.b.value == ""){ alert("Anda belum mengisikan Password"); form.b.focus(); return (false); }																		
	  return (true);
	}
</script>	

<div class="min-h-[80vh] flex items-center justify-center bg-[#F9F9FF] font-['Inter'] py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        
        <!-- Header -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-[#002045]">Login Warga</h2>
            <p class="mt-2 text-sm text-[#43474E]">
                Atau 
                <a href="{{ url('user/pendaftaran') }}" class="font-semibold text-[#002045] hover:underline">
                    daftar akun baru di sini
                </a>
            </p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-2xl shadow-sm border border-[#C4C6CF] overflow-hidden p-8">
            
            @if(session('message'))
                <div class="bg-[#FFDAD6] text-[#BA1A1A] text-[14px] p-4 rounded-lg mb-6 border border-[#BA1A1A]/20">
                    {!! session('message') !!}
                </div>
            @endif

            <form action="{{ url('user/login') }}" method="POST" onsubmit="return validasilogin(this)" class="space-y-6">
                @csrf
                
                <div>
                    <label for="inputEmail3" class="block text-sm font-semibold text-[#111C2C] mb-2">Username atau Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-regular fa-envelope text-gray-400"></i>
                        </div>
                        <input type="text" name="a" id="inputEmail3" class="pl-11 w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" placeholder="Masukkan Username/Email">
                    </div>
                </div>
                
                <div>
                    <label for="inputPassword3" class="block text-sm font-semibold text-[#111C2C] mb-2">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" name="b" id="inputPassword3" class="pl-11 w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" placeholder="Masukkan Password">
                    </div>
                </div>
                
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 text-[#002045] focus:ring-[#002045] border-gray-300 rounded">
                        <label for="remember-me" class="ml-2 block text-sm text-[#43474E]">
                            Ingat saya
                        </label>
                    </div>
                    <div class="text-sm">
                        <a href="#" class="font-semibold text-[#002045] hover:underline">Lupa password?</a>
                    </div>
                </div>
                
                <div class="pt-2">
                    <button type="submit" name="submit" class="w-full bg-[#002045] hover:bg-[#001530] text-white font-medium py-3 px-4 rounded-xl shadow-sm transition-colors flex items-center justify-center h-[48px]">
                        Login
                    </button>
                </div>
                
            </form>
        </div>

        <div class="text-center">
            <a href="{{ url('/') }}" class="text-sm font-medium text-[#43474E] hover:text-[#002045] flex items-center justify-center gap-2">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
<script type="text/javascript">
	function validasireg(form){
		if (form.a.value == ""){ alert("Anda belum mengisikan Username"); form.a.focus(); return (false); }							
		if (form.b.value == ""){ alert("Anda belum mengisikan Password"); form.b.focus(); return (false); }									
		if (form.c.value == ""){ alert("Anda belum menuliskan Nama Lengkap"); form.c.focus(); return (false); }
		if (form.d.value == ""){ alert("Anda belum menuliskan Email"); form.d.focus(); return (false); }
		if (form.e.value == ""){ alert("Anda belum menuliskan No Telpon"); form.e.focus(); return (false); }																		
	  return (true);
	}
</script>	

<div class="bg-[#F9F9FF] font-['Inter'] min-h-screen pb-16">
    <div class="max-w-4xl mx-auto pt-12 px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumb -->
        <div class="text-sm text-[#43474E] mb-6 flex items-center space-x-2">
            <a href="{{ url('/') }}" class="hover:text-[#002045] transition-colors"><i class="fa-solid fa-home"></i> Beranda</a> 
            <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
            <span class="text-[#111C2C] font-semibold">{{ $title ?? 'Registrasi' }}</span>
        </div>

        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-bold text-[#002045]">{{ $title ?? 'Pendaftaran Akun' }}</h2>
            <div class="text-sm text-[#43474E]">
                Sudah punya akun? <a href="{{ url('user/login') }}" class="font-semibold text-[#002045] hover:underline">Login di sini</a>
            </div>
        </div>
        
        <!-- Info Banner -->
        <div class="bg-[#E8F0FE] border border-[#D8E3FA] p-6 rounded-2xl mb-8 shadow-sm">
            <h3 class="text-lg font-bold text-[#002045] mb-3 flex items-center gap-2"><i class="fa-solid fa-circle-info"></i> Syarat dan Ketentuan</h3>
            <div class="text-[#43474E] text-sm leading-relaxed space-y-2">
                <p>"Dengan mengisi formulir registrasi ini, Saya menyatakan bersedia berpartisipasi dalam proses konseling online untuk menceritakan permasalahan dan kehidupan pribadi secara sukarela tanpa ada paksaan dan atau untuk melakukan rangkaian proses konseling psikologis online.</p>
                <p>Dalam kegiatan ini, Psikolog Klinis berkewajiban menjelaskan :</p>
                <ol class="list-decimal pl-5 space-y-1">
                    <li>Proses rinci tentang kegiatan yang akan dilangsungkan merupakan bagian proses penerapan konseling online</li>
                    <li>Tujuan konseling online ini adalah mengenal lebih dalam klien dengan segala issue yang terkait dengannya yang dirasakan penting untuk dibawa dalam proses terapeutik</li>
                    <li>Identitas diri akan dirahasiakan dari pihak mana pun juga sesuai dengan kode etik Psikologi."</li>
                </ol>
            </div>
        </div>

        @if(session('message'))
            <div class="bg-[#FFDAD6] text-[#BA1A1A] border border-[#BA1A1A]/20 p-4 rounded-xl mb-8 shadow-sm text-sm">
                {!! session('message') !!}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-[#C4C6CF] overflow-hidden">
            <div class="p-6 md:p-10">
                <form action="{{ url('user/pendaftaran') }}" enctype='multipart/form-data' method="POST" onSubmit="return validasireg(this)">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        
                        <!-- Biodata Section -->
                        <div class="md:col-span-2">
                            <h4 class="text-lg font-bold text-[#111C2C] border-b border-[#E1E6F3] pb-3 mb-4">Informasi Pribadi</h4>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Nama Depan <span class="text-[#BA1A1A]">*</span></label>
                            <input type="text" name='c' value="{{ old('c') }}" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Nama Belakang <span class="text-[#BA1A1A]">*</span></label>
                            <input type="text" name='cc' value="{{ old('cc') }}" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Jenis Kelamin <span class="text-[#BA1A1A]">*</span></label>
                            <div class="flex items-center space-x-6 mt-3">
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name='kelamin' value='Laki-laki' class="form-radio text-[#002045] focus:ring-[#002045] w-4 h-4" {{ old('kelamin', 'Laki-laki') == 'Laki-laki' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-[#43474E]">Laki-laki</span>
                                </label>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="radio" name='kelamin' value='Perempuan' class="form-radio text-[#002045] focus:ring-[#002045] w-4 h-4" {{ old('kelamin') == 'Perempuan' ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm text-[#43474E]">Perempuan</span>
                                </label>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Pekerjaan <span class="text-[#BA1A1A]">*</span></label>
                            <input type="text" name='perangkat_daerah' value="{{ old('perangkat_daerah') }}" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Tempat Lahir <span class="text-[#BA1A1A]">*</span></label>
                            <input type="text" name='tempat_lahir' value="{{ old('tempat_lahir') }}" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Tanggal Lahir <span class="text-[#BA1A1A]">*</span></label>
                            <input type="date" name='tanggal_lahir' value="{{ old('tanggal_lahir') }}" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Status Pernikahan <span class="text-[#BA1A1A]">*</span></label>
                            <select name='status' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" required>
                                <option value=''>- Pilih Status -</option>
                                <option value='Kawin' {{ old('status') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value='Belum Kawin' {{ old('status') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value='Duda / Janda' {{ old('status') == 'Duda / Janda' ? 'selected' : '' }}>Duda / Janda</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Agama <span class="text-[#BA1A1A]">*</span></label>
                            <select name='agama' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" required>
                                <option value=''>- Pilih Agama -</option>
                                <option value='Islam' {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                <option value='Kristen' {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                <option value='Katolik' {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                <option value='Hindu' {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                <option value='Buddha' {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                <option value='Khonghucu' {{ old('agama') == 'Khonghucu' ? 'selected' : '' }}>Khonghucu</option>
                                <option value='Lainnya' {{ old('agama') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Alamat Lengkap <span class="text-[#BA1A1A]">*</span></label>
                            <textarea name='alamat' rows="3" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" required>{{ old('alamat') }}</textarea>
                        </div>
                        
                        <!-- Contact Section -->
                        <div class="md:col-span-2 mt-6">
                            <h4 class="text-lg font-bold text-[#111C2C] border-b border-[#E1E6F3] pb-3 mb-4">Informasi Kontak & Akun</h4>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">No Telpon / HP <span class="text-[#BA1A1A]">*</span></label>
                            <input type="text" name='e' value="{{ old('e') }}" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" maxlength="15" onkeyup="nospaces(this)" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Alamat Email <span class="text-[#BA1A1A]">*</span></label>
                            <input type="email" name='d' value="{{ old('d') }}" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" onkeyup="nospaces(this)" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Username <span class="text-[#BA1A1A]">*</span></label>
                            <input type="text" name='a' value="{{ old('a') }}" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" maxlength="50" onkeyup="nospaces(this)" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Password <span class="text-[#BA1A1A]">*</span></label>
                            <input type="password" name='b' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" onkeyup="nospaces(this)" maxlength="50" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Konfirmasi Password <span class="text-[#BA1A1A]">*</span></label>
                            <input type="password" name='bb' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" onkeyup="nospaces(this)" maxlength="50" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Foto Profil <span class="text-[#BA1A1A]">*</span></label>
                            <input type="file" name='f' class="w-full px-4 py-2.5 border border-[#C4C6CF] rounded-xl bg-white text-[#43474E] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] transition-colors" accept="image/png, image/jpeg, image/gif" required>
                            <p class="mt-2 text-xs text-[#43474E]">Allowed File: gif, jpg, png, jpeg</p>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-[#111C2C] mb-2">Kode Keamanan <span class="text-[#BA1A1A]">*</span></label>
                            <div class="flex items-center gap-4">
                                <div class="bg-white p-2 rounded-xl border border-[#C4C6CF] shadow-sm">
                                    {!! $image !!}
                                </div>
                                <input name='secutity_code' type="text" class="w-full sm:w-1/2 px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors" placeholder="Masukkan kode captcha" maxlength="6" onkeyup="nospaces(this)" required>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 pt-8 border-t border-[#E1E6F3] flex flex-col sm:flex-row gap-4">
                        <button type="submit" name='submit' class="bg-[#002045] hover:bg-[#001530] text-white font-medium py-3 px-6 rounded-xl shadow-sm transition-colors flex items-center justify-center">
                            Daftar Sekarang
                        </button>
                        <button type="reset" class="bg-[#E1E6F3] hover:bg-[#C4C6CF] text-[#111C2C] font-medium py-3 px-6 rounded-xl shadow-sm transition-colors flex items-center justify-center">
                            Reset Form
                        </button>
                        <a href="{{ url('/') }}" class="bg-white border border-[#C4C6CF] hover:bg-slate-50 text-[#43474E] font-medium py-3 px-6 rounded-xl shadow-sm transition-colors flex items-center justify-center text-center">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

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

<div class="max-w-4xl mx-auto mb-12">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <span class="text-gray-800 font-medium">{{ $title ?? 'Registrasi' }}</span>
    </div>

    <h2 class="text-3xl font-bold text-gray-900 mb-8 pb-3 border-b-2 border-green-600 inline-block">{{ $title ?? 'Pendaftaran' }}</h2>
    
    <div class="bg-yellow-50 border-l-4 border-yellow-500 p-6 rounded-lg mb-8 shadow-sm">
        <h3 class="text-lg font-bold text-yellow-800 mb-3"><i class="fa-solid fa-triangle-exclamation mr-2"></i>Syarat dan Ketentuan</h3>
        <div class="text-yellow-700 text-sm leading-relaxed space-y-2">
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
        <div class="bg-red-50 text-red-700 border-l-4 border-red-500 p-4 rounded-md mb-8 shadow-sm">
            {!! session('message') !!}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-8">
            <form action="{{ url('user/pendaftaran') }}" enctype='multipart/form-data' method="POST" onSubmit="return validasireg(this)">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Biodata -->
                    <div class="space-y-5 md:col-span-2">
                        <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Informasi Pribadi</h4>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Depan <span class="text-red-500">*</span></label>
                        <input type="text" name='c' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nama Belakang <span class="text-red-500">*</span></label>
                        <input type="text" name='cc' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                        <div class="flex items-center space-x-4 mt-2">
                            <label class="inline-flex items-center">
                                <input type="radio" name='kelamin' value='Laki-laki' class="form-radio text-green-600 focus:ring-green-500" checked>
                                <span class="ml-2 text-sm text-gray-700">Laki-laki</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name='kelamin' value='Perempuan' class="form-radio text-green-600 focus:ring-green-500">
                                <span class="ml-2 text-sm text-gray-700">Perempuan</span>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan <span class="text-red-500">*</span></label>
                        <input type="text" name='perangkat_daerah' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                        <input type="text" name='tempat_lahir' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                        <input type="date" name='tanggal_lahir' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm datepicker" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status Pernikahan <span class="text-red-500">*</span></label>
                        <select name='status' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" required>
                            <option value=''>- Pilih Status -</option>
                            <option value='Kawin'>Kawin</option>
                            <option value='Belum Kawin'>Belum Kawin</option>
                            <option value='Duda / Janda'>Duda / Janda</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Agama <span class="text-red-500">*</span></label>
                        <select name='agama' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" required>
                            <option value=''>- Pilih Agama -</option>
                            <option value='Islam'>Islam</option>
                            <option value='Kristen'>Kristen</option>
                            <option value='Katolik'>Katolik</option>
                            <option value='Hindu'>Hindu</option>
                            <option value='Buddha'>Buddha</option>
                            <option value='Khonghucu'>Khonghucu</option>
                            <option value='Lainnya'>Lainnya</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                        <textarea name='alamat' rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" required></textarea>
                    </div>
                    
                    <!-- Kontak -->
                    <div class="space-y-5 md:col-span-2 mt-4">
                        <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-4">Informasi Kontak & Akun</h4>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">No Telpon / HP <span class="text-red-500">*</span></label>
                        <input type="text" name='e' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" maxlength="15" onkeyup="nospaces(this)" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                        <input type="email" name='d' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" onkeyup="nospaces(this)" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
                        <input type="text" name='a' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" maxlength="50" onkeyup="nospaces(this)" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password <span class="text-red-500">*</span></label>
                        <input type="password" name='b' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" onkeyup="nospaces(this)" maxlength="50" required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password <span class="text-red-500">*</span></label>
                        <input type="password" name='bb' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" onkeyup="nospaces(this)" maxlength="50" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto Profil <span class="text-red-500">*</span></label>
                        <input type="file" name='f' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm bg-white" accept="image/png, image/jpeg, image/gif" required>
                        <p class="mt-1 text-xs text-gray-500 italic">Allowed File: gif, jpg, png, jpeg</p>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kode Keamanan <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-4">
                            <div class="bg-gray-100 p-2 rounded border border-gray-200">
                                {!! $image !!}
                            </div>
                            <input name='secutity_code' type="text" class="w-full sm:w-1/2 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" placeholder="Masukkan kode captcha" maxlength="6" onkeyup="nospaces(this)" required>
                        </div>
                    </div>
                </div>

                <div class="mt-10 pt-6 border-t border-gray-200 flex flex-col sm:flex-row gap-3">
                    <button type="submit" name='submit' class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-md shadow-sm transition-colors">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Submit Registrasi
                    </button>
                    <button type="reset" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2.5 px-6 rounded-md shadow-sm transition-colors">
                        <i class="fa-solid fa-rotate-right mr-2"></i> Reset Form
                    </button>
                    <a href="{{ url('/') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-2.5 px-6 rounded-md shadow-sm transition-colors text-center">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

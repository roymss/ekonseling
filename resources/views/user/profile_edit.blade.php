@extends('layouts.app')
@section('content')
<script type="text/javascript">
	function validasireg(form){
		if (form.a.value == ""){ alert("Anda belum mengisikan Username"); form.a.focus(); return (false); }								
		if (form.c.value == ""){ alert("Anda belum menuliskan Nama Lengkap"); form.c.focus(); return (false); }
		if (form.d.value == ""){ alert("Anda belum menuliskan Email"); form.d.focus(); return (false); }
		if (form.e.value == ""){ alert("Anda belum menuliskan No Telpon"); form.e.focus(); return (false); }																		
	  return (true);
	}
</script>	

<div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8 font-['Inter']">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="w-full lg:w-2/3">
            <!-- Breadcrumb -->
            <div class="text-sm text-[#43474E] mb-6 flex items-center space-x-2">
                <a href="{{ url('/') }}" class="hover:text-[#002045] transition-colors"><i class="fa-solid fa-home"></i> Beranda</a> 
                <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
                <span class="text-[#111C2C] font-semibold">{{ $title ?? 'Edit Profile' }}</span>
            </div>

            <h2 class="text-3xl font-bold text-[#002045] mb-8">{{ $title ?? 'Perbarui Profil' }}</h2>
            
            <div class="bg-[#E8F0FE] border border-[#D8E3FA] p-6 rounded-2xl mb-8 shadow-sm">
                <div class="flex gap-3">
                    <i class="fa-solid fa-circle-info text-[#002045] text-xl mt-0.5"></i>
                    <div class="text-[#002045] text-sm leading-relaxed">
                        <strong>PENTING!</strong> Silakan mengisi form di bawah ini dengan data yang sebenarnya untuk keperluan administratif konseling Anda.
                    </div>
                </div>
            </div>

            @if(session('message'))
                <div class="bg-[#FFDAD6] text-[#BA1A1A] border border-[#BA1A1A]/20 p-4 rounded-xl mb-8 shadow-sm text-sm">
                    {!! session('message') !!}
                </div>
            @endif

            @php 
                $nama = explode(' ', $row['nama_lengkap'] ?? '');
                $nama_belakang = isset($nama[1]) ? implode(' ', array_slice($nama, 1)) : '';
            @endphp

            <div class="bg-white rounded-2xl shadow-sm border border-[#C4C6CF] overflow-hidden mb-8">
                <div class="p-6 md:p-10">
                    <form action="{{ url('user/edit_profile') }}" enctype='multipart/form-data' method="POST" onSubmit="return validasireg(this)">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Akun -->
                            <div class="space-y-5 md:col-span-2">
                                <h4 class="text-lg font-bold text-[#111C2C] border-b border-[#E1E6F3] pb-3 mb-2">Informasi Akun</h4>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">Username <span class="text-[#BA1A1A]">*</span></label>
                                <input type="text" name='a' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-slate-100 text-[#43474E] focus:outline-none text-sm cursor-not-allowed" placeholder="Username" value="{{ $row['username'] ?? '' }}" maxlength="50" onkeyup="nospaces(this)" required readonly>
                                <p class="text-xs text-[#43474E] mt-2">Username tidak dapat diubah.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">Password Baru</label>
                                <input type="password" name='b' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" placeholder="Kosongkan jika tidak ingin mengubah password" maxlength="50">
                            </div>

                            <!-- Biodata -->
                            <div class="space-y-5 md:col-span-2 mt-4">
                                <h4 class="text-lg font-bold text-[#111C2C] border-b border-[#E1E6F3] pb-3 mb-2">Informasi Pribadi</h4>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">Nama Depan <span class="text-[#BA1A1A]">*</span></label>
                                <input type="text" name='c' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" value="{{ $nama[0] ?? '' }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">Nama Belakang <span class="text-[#BA1A1A]">*</span></label>
                                <input type="text" name='cc' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" value="{{ $nama_belakang }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">Alamat Email <span class="text-[#BA1A1A]">*</span></label>
                                <input type="email" name='d' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" placeholder="nama_anda@mail.com" value="{{ $row['email'] ?? '' }}" onkeyup="nospaces(this)" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">No Telpon / HP <span class="text-[#BA1A1A]">*</span></label>
                                <input type="number" name='e' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" placeholder="08XXXXXXXXXX" value="{{ $row['no_telp'] ?? '' }}" maxlength="15" onkeyup="nospaces(this)" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">Jenis Kelamin <span class="text-[#BA1A1A]">*</span></label>
                                <div class="flex items-center space-x-6 mt-3">
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name='kelamin' value='Laki-laki' class="form-radio text-[#002045] focus:ring-[#002045] w-4 h-4" {{ ($row['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-[#43474E]">Laki-laki</span>
                                    </label>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="radio" name='kelamin' value='Perempuan' class="form-radio text-[#002045] focus:ring-[#002045] w-4 h-4" {{ ($row['jenis_kelamin'] ?? '') == 'Perempuan' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-[#43474E]">Perempuan</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">Pekerjaan / Perangkat Daerah <span class="text-[#BA1A1A]">*</span></label>
                                <input type="text" name='perangkat_daerah' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" value="{{ $row['perangkat_daerah'] ?? '' }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">Tempat Lahir <span class="text-[#BA1A1A]">*</span></label>
                                <input type="text" name='tempat_lahir' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" value="{{ $row['tempat_lahir'] ?? '' }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">Tanggal Lahir <span class="text-[#BA1A1A]">*</span></label>
                                <input type="date" name='tanggal_lahir' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm datepicker" value="{{ $row['tanggal_lahir'] ?? '' }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">Status Pernikahan <span class="text-[#BA1A1A]">*</span></label>
                                <select name='status' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" required>
                                    @foreach(['Kawin', 'Belum Kawin', 'Duda / Janda'] as $status)
                                        <option value="{{ $status }}" {{ ($row['status_kawin'] ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">Agama <span class="text-[#BA1A1A]">*</span></label>
                                <select name='agama' class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" required>
                                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'] as $agama)
                                        <option value="{{ $agama }}" {{ ($row['agama'] ?? '') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">Alamat Lengkap <span class="text-[#BA1A1A]">*</span></label>
                                <textarea name='alamat' rows="3" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" required>{{ $row['alamat_lengkap'] ?? '' }}</textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-[#111C2C] mb-2">Kode Keamanan <span class="text-[#BA1A1A]">*</span></label>
                                <div class="flex items-center gap-4">
                                    <div class="bg-white p-2 rounded-xl border border-[#C4C6CF] shadow-sm">
                                        {!! $image !!}
                                    </div>
                                    <input name='secutity_code' type="text" class="w-full sm:w-1/2 px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" placeholder="Masukkan kode captcha" maxlength="6" onkeyup="nospaces(this)" required>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 pt-8 border-t border-[#E1E6F3] flex flex-col sm:flex-row gap-4">
                            <button type="submit" name='submit' class="bg-[#002045] hover:bg-[#001530] text-white font-medium py-3 px-6 rounded-xl shadow-sm transition-colors flex items-center justify-center">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ url('user/profile') }}" class="bg-white border border-[#C4C6CF] hover:bg-slate-50 text-[#43474E] font-medium py-3 px-6 rounded-xl shadow-sm transition-colors flex items-center justify-center text-center">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="w-full lg:w-1/3">
            @include('partials.sidebar')
        </div>
    </div>
</div>
@endsection

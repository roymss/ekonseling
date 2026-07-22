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

<div class="max-w-7xl mx-auto mb-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="w-full lg:w-2/3">
            <!-- Breadcrumb -->
            <div class="text-sm text-gray-500 mb-6 flex items-center space-x-2">
                <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
                <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
                <span class="text-gray-800 font-medium">{{ $title ?? 'Edit Profile' }}</span>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-6 pb-3 border-b-2 border-green-600 inline-block">{{ $title ?? 'Edit Profile' }}</h2>
            
            <div class="bg-blue-50 text-blue-800 border-l-4 border-blue-500 p-4 rounded-md mb-6 shadow-sm text-sm">
                <strong><i class="fa-solid fa-circle-info mr-2"></i> PENTING!</strong> Silahkan Mengisi form dibawah ini dengan data yang sebenarnya. Terima kasih,..
            </div>

            @if(session('message'))
                <div class="bg-red-50 text-red-700 border-l-4 border-red-500 p-4 rounded-md mb-6 shadow-sm">
                    {!! session('message') !!}
                </div>
            @endif

            @php 
                $nama = explode(' ', $row['nama_lengkap'] ?? '');
                $nama_belakang = isset($nama[1]) ? implode(' ', array_slice($nama, 1)) : '';
            @endphp

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
                <div class="p-6 sm:p-8">
                    <form action="{{ url('user/edit_profile') }}" enctype='multipart/form-data' method="POST" onSubmit="return validasireg(this)">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <!-- Akun -->
                            <div class="space-y-5 md:col-span-2">
                                <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-2">Informasi Akun</h4>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Username <span class="text-red-500">*</span></label>
                                <input type="text" name='a' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm bg-gray-50" placeholder="Username" value="{{ $row['username'] ?? '' }}" maxlength="50" onkeyup="nospaces(this)" required readonly>
                                <p class="text-xs text-gray-500 mt-1">Username tidak dapat diubah.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
                                <input type="password" name='b' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" placeholder="Kosongkan jika tidak ingin mengubah password" maxlength="50">
                            </div>

                            <!-- Biodata -->
                            <div class="space-y-5 md:col-span-2 mt-4">
                                <h4 class="text-lg font-bold text-gray-800 border-b pb-2 mb-2">Informasi Pribadi</h4>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Depan <span class="text-red-500">*</span></label>
                                <input type="text" name='c' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" value="{{ $nama[0] ?? '' }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Belakang <span class="text-red-500">*</span></label>
                                <input type="text" name='cc' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" value="{{ $nama_belakang }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email <span class="text-red-500">*</span></label>
                                <input type="email" name='d' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" placeholder="nama_anda@mail.com" value="{{ $row['email'] ?? '' }}" onkeyup="nospaces(this)" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">No Telpon / HP <span class="text-red-500">*</span></label>
                                <input type="number" name='e' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" placeholder="08XXXXXXXXXX" value="{{ $row['no_telp'] ?? '' }}" maxlength="15" onkeyup="nospaces(this)" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin <span class="text-red-500">*</span></label>
                                <div class="flex items-center space-x-4 mt-2">
                                    <label class="inline-flex items-center">
                                        <input type="radio" name='kelamin' value='Laki-laki' class="form-radio text-green-600 focus:ring-green-500" {{ ($row['jenis_kelamin'] ?? '') == 'Laki-laki' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Laki-laki</span>
                                    </label>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name='kelamin' value='Perempuan' class="form-radio text-green-600 focus:ring-green-500" {{ ($row['jenis_kelamin'] ?? '') == 'Perempuan' ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Perempuan</span>
                                    </label>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Pekerjaan / Perangkat Daerah <span class="text-red-500">*</span></label>
                                <input type="text" name='perangkat_daerah' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" value="{{ $row['perangkat_daerah'] ?? '' }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tempat Lahir <span class="text-red-500">*</span></label>
                                <input type="text" name='tempat_lahir' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" value="{{ $row['tempat_lahir'] ?? '' }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Lahir <span class="text-red-500">*</span></label>
                                <input type="date" name='tanggal_lahir' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm datepicker" value="{{ $row['tanggal_lahir'] ?? '' }}" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status Pernikahan <span class="text-red-500">*</span></label>
                                <select name='status' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" required>
                                    @foreach(['Kawin', 'Belum Kawin', 'Duda / Janda'] as $status)
                                        <option value="{{ $status }}" {{ ($row['status_kawin'] ?? '') == $status ? 'selected' : '' }}>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Agama <span class="text-red-500">*</span></label>
                                <select name='agama' class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" required>
                                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu', 'Lainnya'] as $agama)
                                        <option value="{{ $agama }}" {{ ($row['agama'] ?? '') == $agama ? 'selected' : '' }}>{{ $agama }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <textarea name='alamat' rows="3" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" required>{{ $row['alamat_lengkap'] ?? '' }}</textarea>
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

                        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row gap-3">
                            <button type="submit" name='submit' class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-md shadow-sm transition-colors">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Perubahan
                            </button>
                            <a href="{{ url('user/profile') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2.5 px-6 rounded-md shadow-sm transition-colors text-center">
                                <i class="fa-solid fa-xmark mr-2"></i> Batal
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

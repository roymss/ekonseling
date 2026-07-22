@extends('layouts.app')
@section('content')
<div class="max-w-7xl mx-auto mb-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="w-full lg:w-2/3">
            <!-- Breadcrumb -->
            <div class="text-sm text-gray-500 mb-6 flex items-center space-x-2">
                <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
                <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
                <span class="text-gray-800 font-medium">{{ $title ?? 'Edit Konsultasi' }}</span>
            </div>

            <h2 class="text-3xl font-bold text-gray-900 mb-8 pb-3 border-b-2 border-green-600 inline-block">{{ $title ?? 'Edit Konsultasi' }}</h2>
            
            @if(session('message'))
                <div class="bg-red-50 text-red-700 border-l-4 border-red-500 p-4 rounded-md mb-6 shadow-sm">
                    {!! session('message') !!}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-8">
                <div class="p-6 sm:p-8">
                    <form action="{{ url('user/konsultasi_edit') }}" enctype="multipart/form-data" method="POST" class="space-y-6">
                        @csrf
                        <input type="hidden" name="id" value="{{ $rows['id_konsul'] ?? '' }}">
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                            <select name="a" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" required>
                                <option value="">- Pilih Kategori Inovasi -</option>
                                @foreach ($kategori as $row)
                                    <option value="{{ $row->id_kategori_konsul ?? $row['id_kategori_konsul'] }}" {{ ($row->id_kategori_konsul ?? $row['id_kategori_konsul']) == ($rows['id_kategori_konsul'] ?? '') ? 'selected' : '' }}>
                                        {{ $row->nama_kategori ?? $row['nama_kategori'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul <span class="text-red-500">*</span></label>
                            <input type="text" name="b" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" value="{{ $rows['judul'] ?? '' }}" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                            <textarea name="h" rows="6" class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm textarea" required>{{ $rows['isi_konsul'] ?? '' }}</textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kode Keamanan <span class="text-red-500">*</span></label>
                            <div class="flex items-center gap-4">
                                <div class="bg-gray-100 p-2 rounded border border-gray-200">
                                    {!! $image !!}
                                </div>
                                <input name="secutity_code" type="text" class="w-full sm:w-1/2 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-1 focus:ring-green-500 focus:border-green-500 text-sm" placeholder="Masukkan kode di samping.." maxlength="6" onkeyup="nospaces(this)" required>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row gap-3">
                            <button type="submit" name="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-md shadow-sm transition-colors">
                                <i class="fa-solid fa-floppy-disk mr-2"></i> Update Data
                            </button>
                            <a href="{{ url('user/konsultasi') }}" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-bold py-2.5 px-6 rounded-md shadow-sm transition-colors text-center">
                                Kembali ke-Awal
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

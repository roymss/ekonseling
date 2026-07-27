@extends('admin.layout.app')

@section('page_title', $title)

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-2xl">
    <div class="p-6 border-b border-gray-200">
        <h3 class="font-bold text-gray-800 text-lg">Edit Kategori Berita</h3>
    </div>

    @if(session('message'))
        <div class="p-4 m-6 mb-0 rounded-lg">
            {!! session('message') !!}
        </div>
    @endif

    <form action="{{ url('admin/edit_kategoriberita/'.$rows->id_kategori) }}" method="POST" class="p-6">
        @csrf
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
            <input type="text" name="a" value="{{ $rows->nama_kategori }}" required class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan nama kategori">
        </div>

        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Aktif</label>
            <div class="flex items-center space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="b" value="Y" {{ $rows->aktif == 'Y' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500 h-4 w-4">
                    <span class="ml-2 text-gray-700">Ya</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="b" value="N" {{ $rows->aktif == 'N' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500 h-4 w-4">
                    <span class="ml-2 text-gray-700">Tidak</span>
                </label>
            </div>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Tampilkan di Sidebar</label>
            <div class="flex items-center space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="c" value="1" {{ $rows->sidebar == '1' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500 h-4 w-4">
                    <span class="ml-2 text-gray-700">Ya</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="c" value="0" {{ $rows->sidebar == '0' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500 h-4 w-4">
                    <span class="ml-2 text-gray-700">Tidak</span>
                </label>
            </div>
        </div>

        <div class="flex space-x-3 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg shadow-sm transition-colors">
                Update
            </button>
            <a href="{{ url('admin/kategoriberita') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-6 rounded-lg transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

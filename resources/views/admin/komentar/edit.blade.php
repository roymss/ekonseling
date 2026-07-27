@extends('admin.layout.app')

@section('page_title', $title)

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden max-w-2xl">
    <div class="p-6 border-b border-gray-200">
        <h3 class="font-bold text-gray-800 text-lg">Edit Komentar</h3>
    </div>

    @if(session('message'))
        <div class="p-4 m-6 mb-0 rounded-lg">
            {!! session('message') !!}
        </div>
    @endif

    <form action="{{ url('admin/edit_komentarberita/'.$rows->id_komentar) }}" method="POST" class="p-6">
        @csrf
        
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pengomentar *</label>
            <input type="text" name="a" value="{{ $rows->nama_komentar }}" required class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
        </div>

        <div class="mb-5 grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Website URL</label>
                <input type="url" name="b" value="{{ $rows->url }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="http://">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="e" value="{{ $rows->email }}" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-700 mb-2">Isi Komentar *</label>
            <textarea name="c" required class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-blue-500 focus:border-blue-500 h-32">{{ $rows->isi_komentar }}</textarea>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Aktif (Tampilkan Komentar)</label>
            <div class="flex items-center space-x-4">
                <label class="inline-flex items-center">
                    <input type="radio" name="d" value="Y" {{ $rows->aktif == 'Y' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500 h-4 w-4">
                    <span class="ml-2 text-gray-700">Ya</span>
                </label>
                <label class="inline-flex items-center">
                    <input type="radio" name="d" value="N" {{ $rows->aktif == 'N' ? 'checked' : '' }} class="text-blue-600 focus:ring-blue-500 h-4 w-4">
                    <span class="ml-2 text-gray-700">Tidak (Sembunyikan)</span>
                </label>
            </div>
        </div>

        <div class="flex space-x-3 pt-4 border-t border-gray-100">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-6 rounded-lg shadow-sm transition-colors">
                Update Komentar
            </button>
            <a href="{{ url('admin/komentarberita') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2 px-6 rounded-lg transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

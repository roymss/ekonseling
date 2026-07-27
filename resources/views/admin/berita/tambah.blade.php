@extends('admin.layout.app')

@section('page_title', $title)

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-200">
        <h3 class="font-bold text-gray-800 text-lg">Tambah Berita Baru</h3>
    </div>

    @if(session('message'))
        <div class="p-4 m-6 mb-0 rounded-lg">
            {!! session('message') !!}
        </div>
    @endif

    <form action="{{ url('admin/tambah_listberita') }}" method="POST" enctype="multipart/form-data" class="p-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Kolom Kiri (Utama) -->
            <div class="md:col-span-2 space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Berita *</label>
                    <input type="text" name="b" required class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Masukkan judul berita">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sub Judul</label>
                    <input type="text" name="c" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-blue-500 focus:border-blue-500" placeholder="Opsional">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Isi Berita *</label>
                    <textarea name="h" required class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-blue-500 focus:border-blue-500 h-64" placeholder="Tuliskan isi berita di sini..."></textarea>
                </div>
            </div>

            <!-- Kolom Kanan (Meta) -->
            <div class="space-y-5 bg-gray-50 p-5 rounded-xl border border-gray-100">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Kategori *</label>
                    <select name="a" required class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                        <option value="">- Pilih Kategori -</option>
                        @foreach($kategori as $kat)
                            <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Sampul (Thumbnail)</label>
                    <input type="file" name="k" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Keterangan Gambar</label>
                    <input type="text" name="i" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-blue-500 focus:border-blue-500 bg-white" placeholder="Caption gambar">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tag/Label</label>
                    <input type="text" name="j" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-blue-500 focus:border-blue-500 bg-white" placeholder="contoh: psikologi, kesehatan">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Video Youtube (ID/URL)</label>
                    <input type="text" name="d" class="w-full rounded-lg border-gray-300 border px-4 py-2 focus:ring-blue-500 focus:border-blue-500 bg-white" placeholder="Opsional">
                </div>
            </div>
        </div>

        <div class="flex space-x-3 pt-6 mt-6 border-t border-gray-100">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-8 rounded-lg shadow-sm transition-colors">
                Publish Berita
            </button>
            <a href="{{ url('admin/listberita') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium py-2.5 px-8 rounded-lg transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection

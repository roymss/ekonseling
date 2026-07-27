@extends('admin.layout.app')

@section('page_title', $title)

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h3 class="font-bold text-gray-800 text-lg">Semua Berita</h3>
        <a href="{{ url('admin/tambah_listberita') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg shadow-sm transition-colors text-sm font-medium flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Berita
        </a>
    </div>

    @if(session('message'))
        <div class="p-4 m-6 mb-0 rounded-lg">
            {!! session('message') !!}
        </div>
    @endif

    <div class="p-6 overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-y border-gray-200">
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700">No</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700">Judul Berita</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700">Kategori</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700">Tgl Posting</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700 text-center">Status</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($berita as $index => $row)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm text-gray-600">{{ ($berita->currentPage() - 1) * $berita->perPage() + $loop->iteration }}</td>
                    <td class="py-3 px-4 text-sm font-medium text-gray-800">
                        <div class="flex items-center space-x-3">
                            @if($row->gambar)
                                <img src="{{ url('asset/foto_berita/'.$row->gambar) }}" class="w-12 h-12 object-cover rounded-md border border-gray-200" alt="Thumbnail">
                            @else
                                <div class="w-12 h-12 bg-gray-100 rounded-md border border-gray-200 flex items-center justify-center text-gray-400"><i class="fa-solid fa-image"></i></div>
                            @endif
                            <span>{{ $row->judul }}</span>
                        </div>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-600">
                        <span class="bg-gray-100 text-gray-700 py-1 px-2 rounded text-xs font-medium">{{ $row->nama_kategori }}</span>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                    <td class="py-3 px-4 text-sm text-center">
                        @if($row->status == 'Y')
                            <a href="{{ url('admin/publish_listberita/'.$row->id_berita.'/N') }}" class="py-1 px-2 rounded text-xs font-semibold bg-green-100 text-green-700 hover:bg-green-200" title="Klik untuk Draft">Published</a>
                        @else
                            <a href="{{ url('admin/publish_listberita/'.$row->id_berita.'/Y') }}" class="py-1 px-2 rounded text-xs font-semibold bg-gray-100 text-gray-700 hover:bg-gray-200" title="Klik untuk Publish">Draft</a>
                        @endif
                    </td>
                    <td class="py-3 px-4 text-center space-x-1">
                        <a href="{{ url('admin/edit_listberita/'.$row->id_berita) }}" class="text-blue-500 hover:text-blue-700 p-2 bg-blue-50 hover:bg-blue-100 rounded transition-colors inline-block" title="Edit">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        <a href="{{ url('admin/delete_listberita/'.$row->id_berita) }}" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?')" class="text-red-500 hover:text-red-700 p-2 bg-red-50 hover:bg-red-100 rounded transition-colors inline-block" title="Hapus">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-500">
                        <i class="fa-solid fa-newspaper text-4xl mb-3 text-gray-300 block"></i>
                        Belum ada data berita.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($berita->hasPages())
    <div class="p-4 border-t border-gray-200">
        {{ $berita->links() }}
    </div>
    @endif
</div>
@endsection

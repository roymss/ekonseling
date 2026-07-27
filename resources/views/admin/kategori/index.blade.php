@extends('admin.layout.app')

@section('page_title', $title)

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h3 class="font-bold text-gray-800 text-lg">Manajemen Kategori Berita</h3>
        <a href="{{ url('admin/tambah_kategoriberita') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg shadow-sm transition-colors text-sm font-medium flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Kategori
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
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700">Nama Kategori</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700 text-center">Aktif</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700 text-center">Sidebar</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategori as $index => $row)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm text-gray-600">{{ ($kategori->currentPage() - 1) * $kategori->perPage() + $loop->iteration }}</td>
                    <td class="py-3 px-4 text-sm font-medium text-gray-800">{{ $row->nama_kategori }}</td>
                    <td class="py-3 px-4 text-sm text-center">
                        <span class="py-1 px-2 rounded text-xs font-semibold {{ $row->aktif == 'Y' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $row->aktif == 'Y' ? 'Ya' : 'Tidak' }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-sm text-center">
                        <span class="py-1 px-2 rounded text-xs font-semibold {{ $row->sidebar == '1' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700' }}">
                            {{ $row->sidebar == '1' ? 'Ya' : 'Tidak' }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center space-x-1">
                        <a href="{{ url('admin/edit_kategoriberita/'.$row->id_kategori) }}" class="text-blue-500 hover:text-blue-700 p-2 bg-blue-50 hover:bg-blue-100 rounded transition-colors inline-block" title="Edit">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        <a href="{{ url('admin/delete_kategoriberita/'.$row->id_kategori) }}" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')" class="text-red-500 hover:text-red-700 p-2 bg-red-50 hover:bg-red-100 rounded transition-colors inline-block" title="Hapus">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-500">
                        <i class="fa-solid fa-folder-open text-4xl mb-3 text-gray-300 block"></i>
                        Belum ada data kategori berita.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($kategori->hasPages())
    <div class="p-4 border-t border-gray-200">
        {{ $kategori->links() }}
    </div>
    @endif
</div>
@endsection

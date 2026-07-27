@extends('admin.layout.app')

@section('page_title', $title)

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h3 class="font-bold text-gray-800 text-lg">Manajemen Komentar Berita</h3>
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
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700">Nama Pengomentar</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700">Isi Komentar</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700">Berita Terkait</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700">Tanggal</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700 text-center">Aktif</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($komentar as $index => $row)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm text-gray-600">{{ ($komentar->currentPage() - 1) * $komentar->perPage() + $loop->iteration }}</td>
                    <td class="py-3 px-4 text-sm font-medium text-gray-800">{{ $row->nama_komentar }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">
                        <div class="line-clamp-2 max-w-xs" title="{{ $row->isi_komentar }}">{{ $row->isi_komentar }}</div>
                    </td>
                    <td class="py-3 px-4 text-sm text-blue-600 hover:underline max-w-xs truncate">
                        {{ $row->judul }}
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($row->tgl)->format('d M Y') }} {{ $row->jam_komentar }}</td>
                    <td class="py-3 px-4 text-sm text-center">
                        <span class="py-1 px-2 rounded text-xs font-semibold {{ $row->aktif == 'Y' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $row->aktif == 'Y' ? 'Ya' : 'Tidak' }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-center space-x-1 whitespace-nowrap">
                        <a href="{{ url('admin/edit_komentarberita/'.$row->id_komentar) }}" class="text-blue-500 hover:text-blue-700 p-2 bg-blue-50 hover:bg-blue-100 rounded transition-colors inline-block" title="Edit">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        <a href="{{ url('admin/delete_komentarberita/'.$row->id_komentar) }}" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?')" class="text-red-500 hover:text-red-700 p-2 bg-red-50 hover:bg-red-100 rounded transition-colors inline-block" title="Hapus">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="py-8 text-center text-gray-500">
                        <i class="fa-solid fa-comments text-4xl mb-3 text-gray-300 block"></i>
                        Belum ada komentar yang masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($komentar->hasPages())
    <div class="p-4 border-t border-gray-200">
        {{ $komentar->links() }}
    </div>
    @endif
</div>
@endsection

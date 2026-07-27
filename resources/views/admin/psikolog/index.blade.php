@extends('admin.layout.app')

@section('page_title', $title)

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-200 flex justify-between items-center">
        <h3 class="font-bold text-gray-800 text-lg">Daftar Psikolog Terdaftar</h3>
        <a href="{{ url('admin/tambah_psikolog') }}" class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg shadow-sm transition-colors text-sm font-medium flex items-center">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Psikolog
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
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700">Nama Lengkap</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700">Username</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700">Email</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700">No. Telp</th>
                    <th class="py-3 px-4 font-semibold text-sm text-gray-700 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($psikologs as $index => $row)
                <tr class="border-b border-gray-100 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                    <td class="py-3 px-4 text-sm font-medium text-gray-800">{{ $row->nama_lengkap }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">
                        <span class="bg-blue-100 text-blue-700 py-1 px-2 rounded text-xs font-semibold">
                            {{ $row->username }}
                        </span>
                    </td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $row->email }}</td>
                    <td class="py-3 px-4 text-sm text-gray-600">{{ $row->no_telp }}</td>
                    <td class="py-3 px-4 text-center">
                        <a href="{{ url('admin/delete_psikolog/'.$row->username) }}" onclick="return confirm('Apakah Anda yakin ingin menghapus akun psikolog ini?')" class="text-red-500 hover:text-red-700 p-2 bg-red-50 hover:bg-red-100 rounded transition-colors inline-block" title="Hapus Akun">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-8 text-center text-gray-500">
                        <i class="fa-solid fa-user-md text-4xl mb-3 text-gray-300 block"></i>
                        Belum ada data psikolog yang ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

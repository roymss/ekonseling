@extends('admin.layout.app')
@section('title', $title)
@section('page_title', $title)
@section('content')

@if(session('message'))
    {!! session('message') !!}
@endif

<div class="flex justify-between items-center mb-4">
    <a href="{{ route('admin.tambah_manajemenuser') }}" class="bg-[#002045] text-white px-4 py-2 rounded shadow hover:bg-[#001530] transition"><i class="fa-solid fa-plus mr-2"></i>Tambah Pengguna Baru</a>
</div>

<div class="overflow-x-auto">
    <table class="min-w-full bg-white border border-[#C4C6CF] rounded-lg">
        <thead class="bg-slate-50 border-b border-[#C4C6CF]">
            <tr>
                <th class="px-4 py-3 text-left text-sm font-semibold text-[#43474E]">No</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-[#43474E]">Username</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-[#43474E]">Nama Lengkap</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-[#43474E]">Email</th>
                <th class="px-4 py-3 text-left text-sm font-semibold text-[#43474E]">No. Telp</th>
                <th class="px-4 py-3 text-center text-sm font-semibold text-[#43474E]">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-[#C4C6CF]">
            @forelse($users as $index => $user)
            <tr class="hover:bg-slate-50 transition">
                <td class="px-4 py-3 text-sm text-[#43474E]">{{ $index + 1 }}</td>
                <td class="px-4 py-3 text-sm text-[#43474E] font-medium">{{ $user->username }}</td>
                <td class="px-4 py-3 text-sm text-[#43474E]">{{ $user->nama_lengkap }}</td>
                <td class="px-4 py-3 text-sm text-[#43474E]">{{ $user->email }}</td>
                <td class="px-4 py-3 text-sm text-[#43474E]">{{ $user->no_telp }}</td>
                <td class="px-4 py-3 text-center">
                    <a href="{{ route('admin.delete_manajemenuser', $user->username) }}" class="text-[#BA1A1A] hover:bg-[#FFDAD6] p-2 rounded transition" onclick="return confirm('Apakah Anda yakin ingin menghapus pengguna ini?')">
                        <i class="fa-solid fa-trash"></i>
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-[#43474E]">Belum ada data pengguna.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection

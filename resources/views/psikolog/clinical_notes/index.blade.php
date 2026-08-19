@extends('layouts.app')
@section('content')
<div class="w-full bg-[#F9F9FF] font-['Inter'] min-h-screen">
    <div class="max-w-[1280px] mx-auto py-12 px-4 md:px-20">
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <a href="{{ route('psikolog.profile') }}" class="text-[#002045] text-sm hover:underline mb-2 inline-block">&larr; Kembali ke Dashboard</a>
                <h1 class="text-3xl font-bold text-[#111C2C]">Catatan Klinis</h1>
                <p class="text-[#43474E] mt-1">Kelola riwayat dan catatan perkembangan pasien Anda.</p>
            </div>
            <a href="{{ route('psikolog.clinical_notes.create') }}" class="bg-[#002045] hover:bg-[#001530] text-white px-5 py-2.5 rounded-lg shadow-sm font-medium transition-colors">
                <i class="fa-solid fa-plus mr-2"></i> Tambah Catatan
            </a>
        </div>
        
        @if(session('success'))
        <div class="bg-[#E8F0FE] border border-[#D8E3FA] text-[#002045] p-4 rounded-lg mb-6 flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
        @endif
        
        <div class="bg-white border border-[#C4C6CF] rounded-xl shadow-sm overflow-hidden">
            @if($notes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-[#F9F9FF] border-b border-[#C4C6CF]">
                        <tr>
                            <th class="py-4 px-6 font-semibold text-[#111C2C] text-sm uppercase tracking-wider">Tanggal</th>
                            <th class="py-4 px-6 font-semibold text-[#111C2C] text-sm uppercase tracking-wider">Nama Pasien</th>
                            <th class="py-4 px-6 font-semibold text-[#111C2C] text-sm uppercase tracking-wider">Diagnosis</th>
                            <th class="py-4 px-6 font-semibold text-[#111C2C] text-sm uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E1E6F3]">
                        @foreach($notes as $note)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6 text-[#43474E] text-sm whitespace-nowrap">{{ \Carbon\Carbon::parse($note->date)->format('d M Y') }}</td>
                            <td class="py-4 px-6 font-medium text-[#111C2C]">{{ $note->patient_name }}</td>
                            <td class="py-4 px-6 text-[#43474E] text-sm max-w-xs truncate">{{ $note->diagnosis }}</td>
                            <td class="py-4 px-6 flex justify-end gap-3">
                                <a href="{{ route('psikolog.clinical_notes.show', $note->id) }}" class="text-[#002045] hover:text-[#001530] bg-[#E8F0FE] hover:bg-[#D8E3FA] p-2 rounded transition-colors" title="Lihat Detail">
                                    <i class="fa-regular fa-eye"></i>
                                </a>
                                <a href="{{ route('psikolog.clinical_notes.edit', $note->id) }}" class="text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 p-2 rounded transition-colors" title="Edit Catatan">
                                    <i class="fa-regular fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('psikolog.clinical_notes.destroy', $note->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan klinis ini?')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 p-2 rounded transition-colors" title="Hapus Catatan">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="py-12 flex flex-col items-center justify-center text-center">
                <div class="w-16 h-16 bg-[#E8F0FE] text-[#002045] rounded-full flex items-center justify-center mb-4">
                    <i class="fa-regular fa-folder-open text-2xl"></i>
                </div>
                <h3 class="text-[#111C2C] text-lg font-bold mb-1">Data Kosong</h3>
                <p class="text-[#43474E] text-sm max-w-sm">Anda belum memiliki catatan klinis pasien. Klik tombol 'Tambah Catatan' untuk memulai.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

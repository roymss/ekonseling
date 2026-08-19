@extends('layouts.app')
@section('content')
<div class="w-full bg-[#F9F9FF] font-['Inter'] min-h-screen">
    <div class="max-w-[1280px] mx-auto py-12 px-4 md:px-20">
        
        <div class="flex justify-between items-center mb-6">
            <div>
                <a href="{{ route('user.profile') }}" class="text-[#002045] text-sm hover:underline mb-2 inline-block">&larr; Kembali ke Dashboard</a>
                <h1 class="text-3xl font-bold text-[#111C2C]">Catatan Klinis Saya</h1>
                <p class="text-[#43474E] mt-1">Daftar rekam medis dan catatan perkembangan konseling Anda.</p>
            </div>
        </div>
        
        <div class="bg-white border border-[#C4C6CF] rounded-xl shadow-sm overflow-hidden">
            @if($notes->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-[#F9F9FF] border-b border-[#C4C6CF]">
                        <tr>
                            <th class="py-4 px-6 font-semibold text-[#111C2C] text-sm uppercase tracking-wider">Tanggal Sesi</th>
                            <th class="py-4 px-6 font-semibold text-[#111C2C] text-sm uppercase tracking-wider">Psikolog / Konselor</th>
                            <th class="py-4 px-6 font-semibold text-[#111C2C] text-sm uppercase tracking-wider">Diagnosis Singkat</th>
                            <th class="py-4 px-6 font-semibold text-[#111C2C] text-sm uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#E1E6F3]">
                        @foreach($notes as $note)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="py-4 px-6 text-[#43474E] text-sm whitespace-nowrap">{{ \Carbon\Carbon::parse($note->date)->format('d M Y') }}</td>
                            <td class="py-4 px-6 font-medium text-[#111C2C]">{{ $note->counselor_name }}</td>
                            <td class="py-4 px-6 text-[#43474E] text-sm max-w-xs truncate">{{ $note->diagnosis }}</td>
                            <td class="py-4 px-6 flex justify-end gap-3">
                                <a href="{{ route('user.clinical_notes.show', $note->id) }}" class="text-[#002045] hover:text-[#001530] bg-[#E8F0FE] hover:bg-[#D8E3FA] px-4 py-2 rounded transition-colors text-sm font-medium" title="Lihat Detail">
                                    <i class="fa-regular fa-file-pdf mr-1"></i> Buka / Download
                                </a>
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
                <p class="text-[#43474E] text-sm max-w-sm">Anda belum memiliki catatan klinis. Catatan akan muncul di sini setelah psikolog merekap hasil konseling Anda.</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

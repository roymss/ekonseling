@extends('layouts.app')
@section('content')
<div class="w-full bg-[#F9F9FF] font-['Inter'] min-h-screen">
    <div class="max-w-[800px] mx-auto py-12 px-4 md:px-0">
        
        <div class="mb-6 flex justify-between items-end">
            <div>
                <a href="{{ route('psikolog.clinical_notes.index') }}" class="text-[#002045] text-sm hover:underline mb-2 inline-block">&larr; Kembali ke Daftar Catatan</a>
                <h1 class="text-3xl font-bold text-[#111C2C]">Detail Catatan Klinis</h1>
            </div>
            <div class="flex gap-2">
                <button onclick="window.print()" class="bg-white border border-[#C4C6CF] text-[#43474E] px-4 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                    <i class="fa-solid fa-print mr-2"></i> Cetak
                </button>
                <a href="{{ route('psikolog.clinical_notes.edit', $note->id) }}" class="bg-[#002045] hover:bg-[#001530] text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fa-regular fa-pen-to-square mr-2"></i> Edit
                </a>
            </div>
        </div>
        
        <div class="bg-white border border-[#C4C6CF] rounded-xl shadow-sm overflow-hidden" id="print-area">
            <div class="p-8 border-b border-[#E1E6F3] bg-[#F9F9FF] flex justify-between items-start">
                <div>
                    <h2 class="text-xl font-bold text-[#111C2C]">Rekam Konseling Psikologi</h2>
                    <p class="text-[#43474E] mt-1 text-sm">Dokumen Rahasia - Hanya untuk Keperluan Klinis</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-semibold text-[#111C2C]">Tanggal Sesi</p>
                    <p class="text-[#002045] font-bold">{{ \Carbon\Carbon::parse($note->date)->format('d F Y') }}</p>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="text-xs font-bold text-[#43474E] uppercase tracking-wider mb-2">Informasi Pasien</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-[#43474E] block">Nama Lengkap</span>
                                <span class="font-semibold text-[#111C2C]">{{ $note->patient_name }}</span>
                            </div>
                            <div>
                                <span class="text-sm text-[#43474E] block">Tanggal Lahir</span>
                                <span class="font-semibold text-[#111C2C]">{{ \Carbon\Carbon::parse($note->patient_birthdate)->format('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-xs font-bold text-[#43474E] uppercase tracking-wider mb-2">Informasi Konselor</h3>
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm text-[#43474E] block">Nama Konselor</span>
                                <span class="font-semibold text-[#111C2C]">{{ $note->counselor_name }}</span>
                            </div>
                            <div>
                                <span class="text-sm text-[#43474E] block">Lisensi / SIPK</span>
                                <span class="font-semibold text-[#111C2C]">{{ $note->counselor_license }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-[#E1E6F3] mb-8">

                <div class="space-y-8">
                    <div>
                        <h3 class="text-sm font-bold text-[#111C2C] mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-stethoscope text-[#002045]"></i> Diagnosis / Hasil Observasi
                        </h3>
                        <div class="bg-[#F9F9FF] p-4 rounded-lg border border-[#E1E6F3]">
                            <p class="text-[#43474E] whitespace-pre-wrap leading-relaxed">{{ $note->diagnosis }}</p>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-sm font-bold text-[#111C2C] mb-3 flex items-center gap-2">
                            <i class="fa-solid fa-briefcase-medical text-[#002045]"></i> Rencana Tindakan / Intervensi
                        </h3>
                        <div class="bg-[#F9F9FF] p-4 rounded-lg border border-[#E1E6F3]">
                            <p class="text-[#43474E] whitespace-pre-wrap leading-relaxed">{{ $note->treatment }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gray-50 px-8 py-4 border-t border-[#C4C6CF] text-xs text-center text-[#43474E]">
                Catatan ini dibuat pada {{ $note->created_at->format('d/m/Y H:i') }}. 
                @if($note->updated_at != $note->created_at)
                Terakhir diupdate pada {{ $note->updated_at->format('d/m/Y H:i') }}.
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    @media print {
        body * {
            visibility: hidden;
        }
        #print-area, #print-area * {
            visibility: visible;
        }
        #print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none;
            box-shadow: none;
        }
    }
</style>
@endsection

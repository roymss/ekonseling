@extends('layouts.app')
@section('content')
<div class="w-full bg-[#F9F9FF] font-['Inter'] min-h-screen">
    <div class="max-w-[800px] mx-auto py-12 px-4 md:px-0">
        
        <div class="mb-6">
            <a href="{{ route('psikolog.clinical_notes.index') }}" class="text-[#002045] text-sm hover:underline mb-2 inline-block">&larr; Kembali ke Daftar Catatan</a>
            <h1 class="text-3xl font-bold text-[#111C2C]">Tambah Catatan Klinis</h1>
            <p class="text-[#43474E] mt-1">Isi detail sesi konseling dan rekam medis pasien.</p>
        </div>
        
        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-lg mb-6">
            <ul class="list-disc ml-5 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="bg-white border border-[#C4C6CF] rounded-xl shadow-sm overflow-hidden">
            <form action="{{ route('psikolog.clinical_notes.store') }}" method="POST" class="p-6 md:p-8">
                @csrf
                
                <h3 class="text-lg font-bold text-[#111C2C] border-b border-[#E1E6F3] pb-3 mb-6">Data Pasien & Sesi</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8" x-data="{
                    patients: {{ json_encode($patients) }},
                    selectedUsername: '{{ old('patient_username') }}',
                    patientName: '{{ old('patient_name') }}',
                    patientBirthdate: '{{ old('patient_birthdate') }}',
                    updatePatient() {
                        const p = this.patients.find(x => x.username === this.selectedUsername);
                        if(p) {
                            this.patientName = p.nama_lengkap;
                            this.patientBirthdate = p.tanggal_lahir;
                        } else {
                            this.patientName = '';
                            this.patientBirthdate = '';
                        }
                    }
                }" x-init="if(selectedUsername) updatePatient()">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-[#111C2C] mb-2">Pilih Pasien <span class="text-[#BA1A1A]">*</span></label>
                        <select name="patient_username" x-model="selectedUsername" @change="updatePatient()" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" required>
                            <option value="">-- Pilih Pasien --</option>
                            @foreach($patients as $p)
                                <option value="{{ $p->username }}">{{ $p->nama_lengkap }} ({{ $p->username }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-[#111C2C] mb-2">Nama Pasien <span class="text-[#BA1A1A]">*</span></label>
                        <input type="text" name="patient_name" x-model="patientName" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-slate-100 text-[#43474E] text-sm pointer-events-none" required readonly>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-[#111C2C] mb-2">Tanggal Lahir Pasien <span class="text-[#BA1A1A]">*</span></label>
                        <input type="date" name="patient_birthdate" x-model="patientBirthdate" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-slate-100 text-[#43474E] text-sm pointer-events-none" required readonly>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-[#111C2C] mb-2">Tanggal Sesi <span class="text-[#BA1A1A]">*</span></label>
                        <input type="date" name="date" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" value="{{ old('date', date('Y-m-d')) }}" required>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-[#111C2C] border-b border-[#E1E6F3] pb-3 mb-6">Hasil Analisis</h3>

                <div class="space-y-6 mb-8">
                    <div>
                        <label class="block text-sm font-semibold text-[#111C2C] mb-2">Diagnosis / Masalah <span class="text-[#BA1A1A]">*</span></label>
                        <textarea name="diagnosis" rows="4" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" placeholder="Tuliskan diagnosis atau keluhan utama..." required>{{ old('diagnosis') }}</textarea>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-[#111C2C] mb-2">Treatment / Intervensi <span class="text-[#BA1A1A]">*</span></label>
                        <textarea name="treatment" rows="4" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" placeholder="Tuliskan langkah penanganan atau saran yang diberikan..." required>{{ old('treatment') }}</textarea>
                    </div>
                </div>

                <h3 class="text-lg font-bold text-[#111C2C] border-b border-[#E1E6F3] pb-3 mb-6">Data Konselor</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    <div>
                        <label class="block text-sm font-semibold text-[#111C2C] mb-2">Nama Konselor <span class="text-[#BA1A1A]">*</span></label>
                        @php
                            $counselorName = '';
                            if(Auth::check()) {
                                $counselorName = Auth::user()->nama_lengkap;
                            } else {
                                $counselorUser = \App\Models\User::where('username', session('username'))->first();
                                $counselorName = $counselorUser ? $counselorUser->nama_lengkap : 'Psikolog';
                            }
                        @endphp
                        <input type="text" name="counselor_name" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" value="{{ old('counselor_name', $counselorName) }}" required>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-semibold text-[#111C2C] mb-2">Lisensi / SIPK <span class="text-[#BA1A1A]">*</span></label>
                        <input type="text" name="counselor_license" class="w-full px-4 py-3 border border-[#C4C6CF] rounded-xl bg-[#F9F9FF] text-[#111C2C] focus:outline-none focus:ring-1 focus:ring-[#002045] focus:border-[#002045] focus:bg-white transition-colors text-sm" value="{{ old('counselor_license') }}" placeholder="No SIPK/Lisensi" required>
                    </div>
                </div>

                <div class="pt-6 border-t border-[#E1E6F3] flex justify-end gap-4">
                    <a href="{{ route('psikolog.clinical_notes.index') }}" class="px-6 py-3 border border-[#C4C6CF] text-[#43474E] font-medium rounded-xl hover:bg-gray-50 transition-colors">Batal</a>
                    <button type="submit" class="px-6 py-3 bg-[#002045] text-white font-medium rounded-xl hover:bg-[#001530] shadow-sm transition-colors flex items-center">
                        <i class="fa-solid fa-floppy-disk mr-2"></i> Simpan Catatan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

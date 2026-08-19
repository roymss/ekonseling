@extends('admin.layout.app')
@section('title', $title)
@section('page_title', $title)
@section('content')

@if(session('message'))
    {!! session('message') !!}
@endif

<form action="{{ route('admin.tambah_manajemenuser') }}" method="POST" class="max-w-2xl">
    @csrf
    
    <div class="mb-4">
        <label class="block text-sm font-semibold text-[#43474E] mb-2">Username <span class="text-red-500">*</span></label>
        <input type="text" name="username" class="w-full border border-[#C4C6CF] rounded p-2.5 focus:outline-none focus:border-[#002045]" required value="{{ old('username') }}">
    </div>
    
    <div class="mb-4">
        <label class="block text-sm font-semibold text-[#43474E] mb-2">Password <span class="text-red-500">*</span></label>
        <input type="password" name="password" class="w-full border border-[#C4C6CF] rounded p-2.5 focus:outline-none focus:border-[#002045]" required>
    </div>
    
    <div class="mb-4">
        <label class="block text-sm font-semibold text-[#43474E] mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
        <input type="text" name="nama_lengkap" class="w-full border border-[#C4C6CF] rounded p-2.5 focus:outline-none focus:border-[#002045]" required value="{{ old('nama_lengkap') }}">
    </div>
    
    <div class="mb-4">
        <label class="block text-sm font-semibold text-[#43474E] mb-2">Email <span class="text-red-500">*</span></label>
        <input type="email" name="email" class="w-full border border-[#C4C6CF] rounded p-2.5 focus:outline-none focus:border-[#002045]" required value="{{ old('email') }}">
    </div>
    
    <div class="mb-6">
        <label class="block text-sm font-semibold text-[#43474E] mb-2">No. Telepon <span class="text-red-500">*</span></label>
        <input type="text" name="no_telp" class="w-full border border-[#C4C6CF] rounded p-2.5 focus:outline-none focus:border-[#002045]" required value="{{ old('no_telp') }}">
    </div>
    
    <div class="flex gap-3 mt-8">
        <button type="submit" class="bg-[#002045] text-white px-6 py-2.5 rounded shadow hover:bg-[#001530] transition font-medium">Simpan</button>
        <a href="{{ route('admin.manajemenuser') }}" class="bg-gray-100 text-[#43474E] border border-[#C4C6CF] px-6 py-2.5 rounded hover:bg-gray-200 transition font-medium">Batal</a>
    </div>
</form>

@endsection

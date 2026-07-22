@extends('layouts.app')
@section('content')
<div class="max-w-4xl mx-auto mb-12">
    <!-- Breadcrumb -->
    <div class="text-sm text-gray-500 mb-6 flex items-center space-x-2">
        <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
        <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
        <span class="text-gray-800 font-medium">{{ $title }}</span>
    </div>

    <h2 class="text-3xl font-bold text-gray-900 mb-8 pb-3 border-b-2 border-green-600 inline-block">{{ $title }}</h2>
    
    @if (session('message'))
        <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-md shadow-sm">
            {{ session('message') }}
        </div>
    @endif
    
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mt-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-800 text-white text-sm uppercase tracking-wider">
                        <th class="py-4 px-6 font-semibold w-16 text-center">No</th>
                        <th class="py-4 px-6 font-semibold">Nama File</th>
                        <th class="py-4 px-6 font-semibold text-center w-32">Hits</th>
                        <th class="py-4 px-6 font-semibold text-center w-32">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                @foreach ($download as $index => $r)
                    <tr class="hover:bg-gray-50 transition-colors {{ $index % 2 == 1 ? 'bg-gray-50' : 'bg-white' }}">
                        <td class="py-4 px-6 text-center font-medium">{{ $download->firstItem() + $index }}</td>
                        <td class="py-4 px-6 font-medium text-gray-900">{{ $r->judul }}</td>
                        <td class="py-4 px-6 text-center">
                            <span class="bg-blue-50 text-blue-700 px-2.5 py-1 rounded-full text-xs font-semibold">{{ $r->hits }} Kali</span>
                        </td>
                        <td class="py-4 px-6 text-center">
                            <a class="inline-flex items-center justify-center bg-green-600 hover:bg-green-700 text-white font-medium py-1.5 px-4 rounded-md transition-colors text-xs" href="{{ url('download/file/'.$r->nama_file) }}">
                                <i class="fa-solid fa-download mr-1.5"></i> Unduh
                            </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>	
    
    <div class="mt-8">
        {{ $download->links('pagination::tailwind') }}	
    </div>
</div>
@endsection

@extends('layouts.app')
@section('content')
@php 
  $usr = \Illuminate\Support\Facades\DB::table('users')->where('username', session('username'))->first();
@endphp
<div class="max-w-7xl mx-auto mb-12">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Main Content -->
        <div class="w-full lg:w-2/3">
            <!-- Breadcrumb -->
            <div class="text-sm text-gray-500 mb-6 flex items-center space-x-2">
                <a href="{{ url('/') }}" class="hover:text-green-600 transition-colors"><i class="fa-solid fa-home"></i> Home</a> 
                <span><i class="fa-solid fa-angle-right text-xs"></i></span> 
                <span class="text-gray-800 font-medium">{{ $title }}</span>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 pb-3 border-b-2 border-green-600">
                <h2 class="text-3xl font-bold text-gray-900 mb-4 sm:mb-0">{{ $title }}</h2>
                @if ($usr && $usr->blokir == 'Y')
                    <button data-modal-target="akunBelumAktifModal" data-modal-toggle="akunBelumAktifModal" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm shadow-sm">
                        <i class="fa-solid fa-plus mr-2"></i> Tambahkan Data
                    </button>
                @else
                    <a href="{{ url('user/konsultasi_tambah') }}" class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition-colors text-sm shadow-sm">
                        <i class="fa-solid fa-plus mr-2"></i> Tambahkan Data
                    </a>
                @endif
            </div>

            @if(session('message'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md shadow-sm">
                    {!! session('message') !!}
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-800 text-white text-sm uppercase tracking-wider">
                                <th class="py-4 px-4 font-semibold w-12 text-center">No</th>
                                <th class="py-4 px-4 font-semibold">Judul Topik</th>
                                <th class="py-4 px-4 font-semibold text-center w-32">Status</th>
                                <th class="py-4 px-4 font-semibold text-center w-28">Komentar</th>
                                <th class="py-4 px-4 font-semibold text-center w-28">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 text-sm divide-y divide-gray-200">
                        @php 
                            $no = 1;
                            $records = \Illuminate\Support\Facades\DB::table('konsul as a')
                                ->join('kategori_konsul as b', 'a.id_kategori_konsul', '=', 'b.id_kategori_konsul')
                                ->where('a.username', session('username'))
                                ->orderBy('a.id_konsul', 'DESC')
                                ->get();
                        @endphp
                        @foreach ($records as $row)
                            @php
                                $komentar_count = \Illuminate\Support\Facades\DB::table('komentar_konsul')->where('id_konsul', $row->id_konsul)->where('aktif', 'Y')->count();
                                if ($row->status == 'Y') { 
                                    $status_html = '<span class="bg-green-100 text-green-800 px-2.5 py-1 rounded-full text-xs font-semibold block mb-1">Published</span> <span class="text-[10px] text-gray-500 italic block">Sudah Terbit</span>'; 
                                } else { 
                                    $status_html = '<span class="bg-red-100 text-red-800 px-2.5 py-1 rounded-full text-xs font-semibold block mb-1">Unpublished</span> <span class="text-[10px] text-gray-500 italic block">Menunggu Validasi</span>'; 
                                }
                                $tgl_posting = tgl_indo($row->tanggal);
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors {{ $no % 2 == 0 ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="py-4 px-4 text-center font-medium">{{ $no }}</td>
                                <td class="py-4 px-4">
                                    <div class="text-xs text-gray-500 mb-1"><i class="fa-regular fa-clock text-green-500 mr-1"></i> {{ $row->hari }}, {{ $tgl_posting }}, {{ $row->jam }} WIB</div>
                                    <a target="_blank" href="{{ url('konsultasi/detail/'.$row->judul_seo) }}" class="font-bold text-gray-900 hover:text-green-600 transition-colors line-clamp-2">{{ $row->judul }}</a>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    {!! $status_html !!}
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center">
                                        <span class="bg-gray-100 text-gray-700 px-2 py-1 rounded text-xs font-medium"><i class="fa-regular fa-comments mr-1"></i> {{ $komentar_count }}</span>
                                    </div>
                                </td>
                                <td class="py-4 px-4 text-center">
                                    <div class="flex items-center justify-center space-x-2">
                                        <a title="Edit Data" href="{{ url('user/konsultasi_edit/'.$row->id_konsul) }}" class="bg-green-500 hover:bg-green-600 text-white p-1.5 rounded transition-colors">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a title="Delete Data" href="{{ url('user/konsultasi_delete/'.$row->id_konsul) }}" onclick="return confirm('Apa anda yakin untuk hapus Data ini?')" class="bg-red-500 hover:bg-red-600 text-white p-1.5 rounded transition-colors">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @php $no++; @endphp
                        @endforeach
                        @if($records->isEmpty())
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500">Belum ada data konsultasi.</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="w-full lg:w-1/3">
            @include('partials.sidebar')
        </div>
    </div>
</div>

<!-- Modal Akun Belum Aktif -->
<div id="akunBelumAktifModal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                    Akun Belum Aktif
                </h3>
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="akunBelumAktifModal">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Close modal</span>
                </button>
            </div>
            <!-- Modal body -->
            <div class="p-4 md:p-5 space-y-4">
                <p class="text-base leading-relaxed text-gray-500 dark:text-gray-400 text-center">
                    Maaf, saat ini akun anda belum aktif, silahkan untuk menunggu paling lambat 1x24 jam agar di verifikasi oleh admin agar bisa melakukan konsultasi. Terima kasih.
                </p>
            </div>
            <!-- Modal footer -->
            <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600 justify-end">
                <button data-modal-hide="akunBelumAktifModal" type="button" class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection

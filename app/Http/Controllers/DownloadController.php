<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DownloadController extends Controller
{
    public function index()
    {
        $title = "Download Dokumen";
        $description = description();
        $keywords = keywords();
        
        $download = DB::table('download')->orderBy('id_download', 'DESC')->paginate(40);
        
        return view('download.index', compact('title', 'description', 'keywords', 'download'));
    }

    public function file($nama_file)
    {
        $row = DB::table('download')->where('nama_file', $nama_file)->first();
        if (!$row) {
            return redirect('download');
        }

        DB::table('download')->where('id_download', $row->id_download)->increment('hits');

        $path = public_path('asset/files/' . $nama_file);
        if (file_exists($path)) {
            return response()->download($path);
        } else {
            return redirect('download')->with('message', 'File tidak ditemukan.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HalamanController extends Controller
{
    public function detail($slug)
    {
        $row = DB::table('halamanstatis')
            ->leftJoin('kategori_halaman', 'halamanstatis.id_kategori_halaman', '=', 'kategori_halaman.id_kategori_halaman')
            ->where('halamanstatis.judul_seo', $slug)
            ->first();

        if (!$row) {
            return redirect('/');
        }

        $title = $row->judul;
        $description = strip_tags($row->isi_halaman);
        $keywords = str_replace(' ', ', ', $row->judul);
        $rows = $row;

        DB::table('halamanstatis')->where('id_halaman', $row->id_halaman)->increment('dibaca');

        return view('halaman.detail', compact('title', 'description', 'keywords', 'rows'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    public function detail($slug)
    {
        $row = DB::table('kategori')->where('kategori_seo', $slug)->first();

        if (!$row) {
            return redirect('/');
        }

        $title = "Berita Kategori " . $row->nama_kategori;
        $description = description();
        $keywords = keywords();
        $rows = $row;

        $beritakategori = DB::table('berita')
            ->join('users', 'berita.username', '=', 'users.username')
            ->join('kategori', 'berita.id_kategori', '=', 'kategori.id_kategori')
            ->where('berita.status', 'Y')
            ->where('berita.id_kategori', $row->id_kategori)
            ->orderBy('berita.id_berita', 'DESC')
            ->paginate(5);

        return view('kategori.detail', compact('title', 'description', 'keywords', 'rows', 'beritakategori'));
    }
}

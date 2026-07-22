<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MainController extends Controller
{
    public function index()
    {
        $title = title();
        $description = description();
        $keywords = keywords();

        $terkini = DB::table('berita')
            ->join('users', 'berita.username', '=', 'users.username')
            ->join('kategori', 'berita.id_kategori', '=', 'kategori.id_kategori')
            ->where('berita.status', 'Y')
            ->orderBy('berita.id_berita', 'DESC')
            ->limit(4)
            ->get();
            
        return view('home', compact('title', 'description', 'keywords', 'terkini'));
    }
}

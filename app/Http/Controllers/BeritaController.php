<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BeritaController extends Controller
{
    public function index()
    {
        $title = "Semua Berita";
        $description = description();
        $keywords = keywords();
        
        $berita = DB::table('berita')
            ->join('users', 'berita.username', '=', 'users.username')
            ->join('kategori', 'berita.id_kategori', '=', 'kategori.id_kategori')
            ->where('berita.status', 'Y')
            ->orderBy('berita.id_berita', 'DESC')
            ->paginate(5);
            
        return view('berita.index', compact('title', 'description', 'keywords', 'berita'));
    }

    public function detail($slug)
    {
        $row = DB::table('berita')
            ->join('users', 'berita.username', '=', 'users.username')
            ->join('kategori', 'berita.id_kategori', '=', 'kategori.id_kategori')
            ->where('berita.judul_seo', $slug)
            ->where('berita.status', 'Y')
            ->first();

        if (!$row) {
            return redirect('/');
        }

        $title = $row->judul;
        $description = strip_tags(substr($row->isi_berita, 0, 500));
        $keywords = $row->tag;
        $rows = $row;

        DB::table('berita')->where('id_berita', $row->id_berita)->increment('dibaca');

        // Captcha implementation is omitted for initial migration ->
        $image = '<!-- Captcha Laravel (coming soon) -->';
        
        return view('berita.detail', compact('title', 'description', 'keywords', 'rows', 'image'));
    }

    public function kirim_komentar(Request $request)
    {
        $id_berita = $request->input('a');
        $isi_komentar = $request->input('d');
        $email = $request->input('e');

        $berita = DB::table('berita')->where('id_berita', $id_berita)->first();
        if (!$berita) {
            return redirect('/');
        }

        $user = DB::table('users')->where('username', session('username'))->first();
        if ($user) {
            DB::table('komentar')->insert([
                'id_berita' => $id_berita,
                'nama_komentar' => $user->nama_lengkap,
                'url' => $user->username,
                'isi_komentar' => $isi_komentar,
                'tgl' => date('Y-m-d'),
                'jam_komentar' => date('H:i:s'),
                'aktif' => 'N',
                'email' => $email
            ]);
            
            return redirect('berita/detail/' . $berita->judul_seo . '#listcomment')
                ->with('message', 'Pesan telah terkirim dan akan muncul setelah disetujui!');
        }

        return back()->with('message', 'Anda harus login untuk berkomentar.');
    }
}

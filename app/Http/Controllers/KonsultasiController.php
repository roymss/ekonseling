<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KonsultasiController extends Controller
{
    public function detail($slug)
    {
        $row = DB::table('konsul')
            ->join('users', 'konsul.username', '=', 'users.username')
            ->join('kategori_konsul', 'konsul.id_kategori_konsul', '=', 'kategori_konsul.id_kategori_konsul')
            ->where('konsul.judul_seo', $slug)
            ->where('konsul.status', 'Y')
            ->first();

        if (!$row) {
            return redirect('/');
        }

        if (session('username') == $row->username || session('level') == 'admin' || session('level') == 'user') {
            $title = $row->judul;
            $description = strip_tags(substr($row->isi_konsul, 0, 500));
            $keywords = $row->judul;
            $rows = $row;
            
            $image = '<!-- Captcha Laravel (coming soon) -->';

            return view('konsultasi.detail', compact('title', 'description', 'keywords', 'rows', 'image'));
        } else {
            return redirect('user/konsultasi');
        }
    }

    public function kirim_komentar(Request $request)
    {
        $id_konsul = $request->input('a');
        $isi_komentar = $request->input('d');
        $email = $request->input('e');

        $row = DB::table('konsul')->where('id_konsul', $id_konsul)->first();
        if (!$row) {
            return redirect('/');
        }

        $user = DB::table('users')->where('username', session('username'))->first();
        if ($user) {
            if ($user->level == 'inovator') { 
                $level_str = ''; 
            } elseif ($user->level == 'admin') { 
                $level_str = 'Admin'; 
            } else { 
                $level_str = 'Psikolog'; 
            }

            DB::table('komentar_konsul')->insert([
                'id_konsul' => $id_konsul,
                'nama_komentar' => $user->nama_lengkap . ' (' . $level_str . ')',
                'url' => $user->username,
                'isi_komentar' => $isi_komentar,
                'tgl' => date('Y-m-d'),
                'jam_komentar' => date('H:i:s'),
                'aktif' => 'Y',
                'email' => $email
            ]);
        }

        return redirect('konsultasi/detail/' . $row->judul_seo . '#listcomment');
    }
}

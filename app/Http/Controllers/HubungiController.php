<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HubungiController extends Controller
{
    public function index()
    {
        $row = DB::table('mod_alamat')->where('id_alamat', 1)->first();
        $iden = DB::table('identitas')->where('id_identitas', 1)->first();
        
        $title = 'Hubungi Kami';
        $description = 'Silahkan Mengisi Form Dibawah ini untuk menghubungi kami';
        $keywords = 'hubungi, kontak, kritik, saran, pesan';
        $rows = $row;
        $image = '<!-- Captcha Laravel (coming soon) -->';

        return view('hubungi.index', compact('title', 'description', 'keywords', 'rows', 'iden', 'image'));
    }

    public function kirim(Request $request)
    {
        $nama = $request->input('a');
        $email = $request->input('b');
        $pesan = $request->input('c');
        $subjek = $request->ip();

        DB::table('hubungi')->insert([
            'nama' => $nama,
            'email' => $email,
            'subjek' => $subjek,
            'pesan' => $pesan,
            'tanggal' => date('Y-m-d'),
            'jam' => date('H:i:s')
        ]);

        return redirect('hubungi')->with('message', 'Pesan telah terkirim dan segera kami respon!');
    }
}

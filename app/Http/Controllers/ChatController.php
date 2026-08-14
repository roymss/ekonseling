<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // Tampilkan halaman Live Chat (Full UI)
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('user/login');
        }

        $title = 'Live Chat Konsultasi';
        $kategori = DB::table('kategori_konsul')->where('aktif', 'Y')->get();

        // Ambil daftar psikolog untuk pilihan
        $psikologs = DB::table('users')->where('level', 'psikolog')->get();

        // Ambil daftar chat room (konsul) milik user ini, urutkan dari yang terbaru
        $rooms = DB::table('konsul')
            ->where('username', $user->username)
            ->orderBy('id_konsul', 'DESC')
            ->get();

        return view('user.chat', compact('title', 'kategori', 'rooms', 'user', 'psikologs'));
    }

    // AJAX Endpoint: Ambil pesan dari suatu room
    public function fetchMessages(Request $request)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['status' => 'error', 'message' => 'Unauthorized']);

        $id_konsul = $request->input('id_konsul');

        $room = DB::table('konsul')
            ->where('id_konsul', $id_konsul)
            ->where('username', $user->username)
            ->first();

        if (!$room) {
            return response()->json(['status' => 'error', 'message' => 'Room not found']);
        }

        // Tandai pesan sebagai dibaca
        DB::table('komentar_konsul')
            ->where('id_konsul', $id_konsul)
            ->where('url', '!=', $user->username)
            ->where('dibaca', 'N')
            ->update(['dibaca' => 'Y']);

        // Pesan pembuka (Dari form tambah konsul awal)
        $messages = [];
        $messages[] = [
            'id' => 0,
            'is_me' => true,
            'sender' => $user->nama_lengkap ?? $user->username,
            'text' => $room->isi_konsul,
            'time' => $room->tanggal . ' ' . $room->jam
        ];

        // Pesan-pesan balasan
        $replies = DB::table('komentar_konsul')
            ->where('id_konsul', $id_konsul)
            ->orderBy('tgl', 'ASC')
            ->orderBy('jam_komentar', 'ASC')
            ->get();

        foreach ($replies as $reply) {
            $messages[] = [
                'id' => $reply->id_komentar,
                'is_me' => ($reply->url == $user->username), // jika url (username) sama dengan user login
                'sender' => $reply->nama_komentar,
                'text' => $reply->isi_komentar,
                'time' => $reply->tgl . ' ' . $reply->jam_komentar
            ];
        }

        return response()->json([
            'status' => 'success',
            'room' => $room,
            'messages' => $messages
        ]);
    }

    // AJAX Endpoint: Kirim pesan
    public function sendMessage(Request $request)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['status' => 'error', 'message' => 'Unauthorized']);

        $id_konsul = $request->input('id_konsul');
        $isi_komentar = $request->input('message');

        // Pastikan room valid
        $room = DB::table('konsul')->where('id_konsul', $id_konsul)->first();
        if (!$room) return response()->json(['status' => 'error']);

        DB::table('komentar_konsul')->insert([
            'id_konsul' => $id_konsul,
            'nama_komentar' => ($user->nama_lengkap ?? $user->username) . ' (Pasien)',
            'url' => $user->username,
            'isi_komentar' => $isi_komentar,
            'tgl' => date('Y-m-d'),
            'jam_komentar' => date('H:i:s'),
            'aktif' => 'Y',
            'email' => $user->email ?? ''
        ]);

        return response()->json(['status' => 'success']);
    }

    // AJAX Endpoint: Buat room baru (Percakapan baru)
    public function createRoom(Request $request)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['status' => 'error']);

        $kategori = $request->input('kategori');
        $judul = $request->input('judul');
        $pesan = $request->input('pesan');

        $psikolog = $request->input('psikolog');

        $hari_ini = \Carbon\Carbon::now()->translatedFormat('l');

        $id = DB::table('konsul')->insertGetId([
            'id_kategori_konsul' => $kategori,
            'username_psikolog' => $psikolog,
            'username' => $user->username,
            'judul' => $judul,
            'judul_seo' => \Illuminate\Support\Str::slug($judul) . '-' . time(),
            'isi_konsul' => $pesan,
            'hari' => $hari_ini,
            'tanggal' => date('Y-m-d'),
            'jam' => date('H:i:s'),
            'status' => 'Y'
        ]);

        return response()->json(['status' => 'success', 'id_konsul' => $id]);
    }

    // AJAX Endpoint: Cek pesan belum terbaca untuk semua room
    public function checkUnread(Request $request)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['status' => 'error']);

        $unreads = [];
        $rooms = DB::table('konsul')->where('username', $user->username)->get();
        
        foreach ($rooms as $room) {
            $count = DB::table('komentar_konsul')
                ->where('id_konsul', $room->id_konsul)
                ->where('url', '!=', $user->username)
                ->where('dibaca', 'N')
                ->count();
            $unreads[$room->id_konsul] = $count;
        }

        return response()->json(['status' => 'success', 'unreads' => $unreads]);
    }
}

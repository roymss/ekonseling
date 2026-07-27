<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class PsikologChatController extends Controller
{
    // Tampilkan halaman Live Chat khusus Psikolog
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect('user/login');
        }

        $title = 'Dashboard Psikolog - Live Chat';
        
        $rooms = DB::table('konsul')
            ->select('konsul.*', 'users.nama_lengkap as nama_pasien')
            ->leftJoin('users', 'konsul.username', '=', 'users.username')
            ->where(function($query) use ($user) {
                $query->whereNull('username_psikolog')
                      ->orWhere('username_psikolog', '')
                      ->orWhere('username_psikolog', $user->username);
            })
            ->orderBy('id_konsul', 'DESC')
            ->get();

        return view('psikolog.chat', compact('title', 'rooms', 'user'));
    }

    // AJAX Endpoint: Ambil pesan dari suatu room
    public function fetchMessages(Request $request)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['status' => 'error', 'message' => 'Unauthorized']);

        $id_konsul = $request->input('id_konsul');

        $room = DB::table('konsul')
            ->select('konsul.*', 'users.nama_lengkap as nama_pasien')
            ->leftJoin('users', 'konsul.username', '=', 'users.username')
            ->where('id_konsul', $id_konsul)
            ->first();

        if (!$room) {
            return response()->json(['status' => 'error', 'message' => 'Room not found']);
        }

        // Pesan pembuka (Dari form tambah konsul awal)
        $messages = [];
        $messages[] = [
            'id' => 0,
            'is_me' => false, // Psikolog melihat pesan ini sebagai pesan dari pasien
            'sender' => $room->nama_pasien ?? $room->username,
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
                'is_me' => ($reply->url == $user->username), // jika url (username) sama dengan user login (psikolog)
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

    // AJAX Endpoint: Kirim pesan balasan dari Psikolog
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
            'nama_komentar' => ($user->nama_lengkap ?? $user->username) . ' (Psikolog)',
            'url' => $user->username,
            'isi_komentar' => $isi_komentar,
            'tgl' => date('Y-m-d'),
            'jam_komentar' => date('H:i:s'),
            'aktif' => 'Y',
            'email' => $user->email ?? ''
        ]);

        return response()->json(['status' => 'success']);
    }
}

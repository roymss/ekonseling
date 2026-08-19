<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

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

    public function profile()
    {
        $title = 'Profile Psikolog';
        $user = Auth::user();
        if (!$user) {
            $user = User::where('username', session('username'))->first();
            if ($user) Auth::login($user);
        }
        $row = $user;
        $image = captcha_img();
        
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
            
        return view('psikolog.profile', compact('title', 'row', 'image', 'rooms'));
    }

    public function konsultasi_reschedule(Request $request, $id)
    {
        $user = Auth::user();
        
        $rules = [
            'tanggal' => 'required|date',
            'jam' => 'required'
        ];
        
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->with('message', '<div class="alert alert-danger">Harap pilih tanggal dan jam yang valid!</div>');
        }
        
        DB::table('konsul')->where('id_konsul', $id)->where('username_psikolog', $user->username)->update([
            'tanggal' => $request->input('tanggal'),
            'jam' => $request->input('jam'),
        ]);
        
        return redirect()->route('psikolog.profile')->with('message', '<div class="alert alert-success">Jadwal konsultasi berhasil diubah.</div>');
    }

    public function edit_profile(Request $request)
    {
        $user = Auth::user();
        
        if ($request->isMethod('post')) {
            $rules = [
                'c' => 'required',
                'cc' => 'required',
                'd' => 'required|email|unique:users,email,' . $user->username . ',username',
                'e' => 'required',
                'secutity_code' => 'required|captcha'
            ];

            $messages = [
                'd.unique' => 'Email sudah digunakan!',
                'secutity_code.captcha' => 'Kode keamanan salah!'
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('message', '<div class="alert alert-danger">' . implode('<br>', $validator->errors()->all()) . '</div>');
            }

            if ($request->filled('b')) {
                $user->password = Hash::make($request->input('b'));
            }

            $user->nama_lengkap = trim($request->input('c') . ' ' . $request->input('cc'));
            $user->email = $request->input('d');
            $user->no_telp = $request->input('e');
            $user->jenis_kelamin = $request->input('kelamin');
            $user->perangkat_daerah = $request->input('perangkat_daerah');
            $user->tempat_lahir = $request->input('tempat_lahir');
            $user->tanggal_lahir = $request->input('tanggal_lahir');
            $user->status_kawin = $request->input('status');
            $user->agama = $request->input('agama');
            $user->alamat_lengkap = $request->input('alamat');
            $user->save();

            return redirect('psikolog/profile')->with('message', '<div class="alert alert-success">Profile berhasil diperbarui.</div>');
        }

        return redirect('psikolog/profile');
    }

    public function foto(Request $request)
    {
        $user = Auth::user();
        
        if ($request->hasFile('f')) {
            $file = $request->file('f');
            
            $validator = Validator::make($request->all(), [
                'f' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->with('message', '<div class="alert alert-danger">Gagal! File harus berupa gambar dan ukuran maksimal 2MB.</div>');
            }

            if ($user->foto && file_exists(public_path('asset/foto_user/' . $user->foto))) {
                unlink(public_path('asset/foto_user/' . $user->foto));
            }

            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('asset/foto_user'), $filename);
            
            DB::table('users')->where('username', $user->username)->update(['foto' => $filename]);
            
            return redirect('psikolog/profile')->with('message', '<div class="alert alert-success">Foto profile berhasil diperbarui.</div>');
        }
        
        return redirect()->back()->with('message', '<div class="alert alert-danger">Tidak ada file yang dipilih.</div>');
    }

    // AJAX Endpoint: Cek pesan belum terbaca untuk semua room
    public function checkUnread(Request $request)
    {
        $user = Auth::user();
        if (!$user) return response()->json(['status' => 'error']);

        $unreads = [];
        $rooms = DB::table('konsul')
            ->where(function($query) use ($user) {
                $query->whereNull('username_psikolog')
                      ->orWhere('username_psikolog', '')
                      ->orWhere('username_psikolog', $user->username);
            })
            ->get();
        
        foreach ($rooms as $room) {
            $count = DB::table('komentar_konsul')
                ->where('id_konsul', $room->id_konsul)
                ->where('url', '!=', $user->username)
                ->where('dibaca', 'N')
                ->count();
            
            // Check if initial message is unread (no comments yet)
            if ($count == 0) {
                $hasComments = DB::table('komentar_konsul')->where('id_konsul', $room->id_konsul)->exists();
                if (!$hasComments) {
                    $count = 1; // Unread initial message from patient
                }
            }
                
            $unreads[$room->id_konsul] = $count;
        }

        return response()->json(['status' => 'success', 'unreads' => $unreads]);
    }
}

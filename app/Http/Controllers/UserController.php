<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            if (Auth::user()->level === 'psikolog') {
                return redirect('psikolog/chat');
            }
            return redirect()->route('user.profile');
        }
        return redirect()->route('user.login');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $credentials = [
                'username' => $request->input('a'),
                'password' => $request->input('b'),
            ];

            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $request->session()->regenerate();
                session([
                    'upload_image_file_manager' => true,
                    'username' => $user->username,
                    'level' => $user->level,
                    'id_session' => $user->id_session,
                ]);
                if ($user->level === 'psikolog') {
                    return redirect()->intended('psikolog/chat');
                }
                return redirect()->intended('user/profile');
            }

            // Check if legacy md5 password
            $user = User::where('username', $credentials['username'])
                ->where('password', md5($credentials['password']))
                ->first();

            if ($user) {
                // Update password to bcrypt
                $user->password = Hash::make($credentials['password']);
                $user->save();

                Auth::login($user);
                $request->session()->regenerate();
                session([
                    'upload_image_file_manager' => true,
                    'username' => $user->username,
                    'level' => $user->level,
                    'id_session' => $user->id_session,
                ]);
                if ($user->level === 'psikolog') {
                    return redirect()->intended('psikolog/chat');
                }
                return redirect()->intended('user/profile');
            }

            return redirect()->back()->with('message', 'Username atau Password salah!');
        }

        $title = 'Login Area';
        return view('user.login', compact('title'));
    }

    public function pendaftaran(Request $request)
    {
        if ($request->isMethod('post')) {
            $rules = [
                'a' => 'required|unique:users,username',
                'b' => 'required',
                'bb' => 'required|same:b',
                'c' => 'required',
                'd' => 'required|email|unique:users,email',
                'e' => 'required',
                'secutity_code' => 'required|captcha'
            ];

            $messages = [
                'a.unique' => 'Username sudah digunakan!',
                'd.unique' => 'Email sudah digunakan!',
                'bb.same' => 'Konfirmasi password tidak cocok!',
                'secutity_code.captcha' => 'Kode keamanan salah!'
            ];
            
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('message', '<div class="alert alert-danger">' . implode('<br>', $validator->errors()->all()) . '</div>');
            }

            $user = new User();
            $user->username = $request->input('a');
            $user->password = Hash::make($request->input('b'));
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
            $user->level = 'user';
            $user->blokir = 'N';
            $user->id_session = md5($request->input('a') . time());

            if ($request->hasFile('f')) {
                $file = $request->file('f');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('asset/foto_user'), $filename);
                $user->foto = $filename;
            } else {
                $user->foto = '';
            }

            $user->save();

            return redirect('user/login')->with('message', '<div class="alert alert-success">Pendaftaran berhasil. Silahkan login.</div>');
        }

        $title = 'Pendaftaran';
        $image = captcha_img();
        return view('user.register', compact('title', 'image'));
    }

    public function profile()
    {
        $title = 'Profile User';
        $row = Auth::user();
        if (!$row) {
            $row = User::where('username', session('username'))->first();
            if ($row) Auth::login($row);
        }
        $image = captcha_img();
        return view('user.profile', compact('title', 'row', 'image'));
    }

    public function edit_profile(Request $request)
    {
        $user = Auth::user();
        
        if ($request->isMethod('post')) {
            $rules = [
                'c' => 'required',
                'cc' => 'required',
                'd' => 'required|email|unique:users,email,' . $user->id,
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

            return redirect('user/profile')->with('message', '<div class="alert alert-success">Profile berhasil diperbarui.</div>');
        }

        $title = 'Edit Profile';
        $row = $user;
        $image = captcha_img();
        return view('user.profile_edit', compact('title', 'row', 'image'));
    }

    public function foto(Request $request)
    {
        \Illuminate\Support\Facades\Log::info('UserController@foto request: ', $request->all());
        \Illuminate\Support\Facades\Log::info('UserController@foto diakses oleh: ' . session('username') . ' dengan file: ' . ($request->hasFile('f') ? 'ADA' : 'TIDAK ADA'));
        $user = Auth::user();
        if (!$user) {
            $user = \App\Models\User::where('username', session('username'))->first();
            if ($user) \Illuminate\Support\Facades\Auth::login($user);
        }
        
        if ($request->hasFile('f')) {
            $file = $request->file('f');
            
            $validator = Validator::make($request->all(), [
                'f' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);
            
            if ($validator->fails()) {
                return redirect()->back()->with('message', '<div class="alert alert-danger">Gagal! File harus berupa gambar dan ukuran maksimal 2MB.</div>');
            }

            // Hapus foto lama jika ada dan bukan kosong
            if ($user->foto && file_exists(public_path('asset/foto_user/' . $user->foto))) {
                unlink(public_path('asset/foto_user/' . $user->foto));
            }

            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('asset/foto_user'), $filename);
            
            \Illuminate\Support\Facades\DB::table('users')->where('username', $user->username)->update(['foto' => $filename]);
            
            return redirect('user/profile')->with('message', '<div class="alert alert-success">Foto profile berhasil diperbarui.</div>');
        } elseif ($request->has('f')) {
            $file = $request->file('f');
            $error = $file ? $file->getError() : 'unknown';
            \Illuminate\Support\Facades\Log::error('Upload error code: ' . $error);
            return redirect()->back()->with('message', '<div class="alert alert-danger">Gagal! Terjadi kesalahan server saat mengunggah (Error Code: ' . $error . '). Silakan coba gambar lain.</div>');
        }
        
        return redirect()->back()->with('message', '<div class="alert alert-danger">Tidak ada file yang dipilih.</div>');
    }

    public function konsultasi()
    {
        $title = 'Data Konsultasi Saya';
        return view('konsultasi.index', compact('title'));
    }

    public function konsultasi_tambah(Request $request)
    {
        $user = Auth::user();
        
        if ($request->isMethod('post')) {
            $rules = [
                'a' => 'required', // Kategori
                'b' => 'required', // Judul
                'c' => 'required'  // Isi
            ];
            
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('message', '<div class="alert alert-danger">Harap isi semua field!</div>');
            }
            
            $hari_ini = \Carbon\Carbon::now()->translatedFormat('l');
            
            DB::table('konsul')->insert([
                'id_kategori_konsul' => $request->input('a'),
                'username' => $user->username,
                'judul' => $request->input('b'),
                'judul_seo' => \Illuminate\Support\Str::slug($request->input('b')),
                'isi_konsul' => $request->input('c'),
                'hari' => $hari_ini,
                'tanggal' => date('Y-m-d'),
                'jam' => date('H:i:s'),
                'status' => 'Y'
            ]);
            
            return redirect('user/konsultasi')->with('message', '<div class="alert alert-success">Konsultasi berhasil ditambahkan.</div>');
        }
        
        $title = 'Tambah Konsultasi';
        $kategori = DB::table('kategori_konsul')->where('aktif', 'Y')->get();
        $image = captcha_img();
        return view('user.konsultasi_tambah', compact('title', 'kategori', 'image'));
    }

    public function konsultasi_edit(Request $request, $id)
    {
        $user = Auth::user();
        $row = DB::table('konsul')->where('id_konsul', $id)->where('username', $user->username)->first();
        
        if (!$row) {
            return redirect('user/konsultasi')->with('message', '<div class="alert alert-danger">Data tidak ditemukan!</div>');
        }
        
        if ($request->isMethod('post')) {
            $rules = [
                'a' => 'required',
                'b' => 'required',
                'c' => 'required'
            ];
            
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->with('message', '<div class="alert alert-danger">Harap isi semua field!</div>');
            }
            
            DB::table('konsul')->where('id_konsul', $id)->update([
                'id_kategori_konsul' => $request->input('a'),
                'judul' => $request->input('b'),
                'judul_seo' => \Illuminate\Support\Str::slug($request->input('b')),
                'isi_konsul' => $request->input('c')
            ]);
            
            return redirect('user/konsultasi')->with('message', '<div class="alert alert-success">Konsultasi berhasil diupdate.</div>');
        }
        
        $title = 'Edit Konsultasi';
        $kategori = DB::table('kategori_konsul')->where('aktif', 'Y')->get();
        $rows = $row; // match blade variable
        $image = captcha_img();
        return view('user.konsultasi_edit', compact('title', 'kategori', 'rows', 'image'));
    }

    public function konsultasi_delete($id)
    {
        $user = Auth::user();
        DB::table('konsul')->where('id_konsul', $id)->where('username', $user->username)->delete();
        
        // Also delete comments
        DB::table('komentar_konsul')->where('id_konsul', $id)->delete();
        
        return redirect('user/konsultasi')->with('message', '<div class="alert alert-success">Konsultasi berhasil dihapus.</div>');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('user/login');
    }
}

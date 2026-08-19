<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function index(Request $request)
    {
        if (session('level') == 'admin') {
            return redirect('admin/dashboard');
        }

        if ($request->isMethod('post')) {
            $username = $request->input('a');
            $password = hash("sha512", md5($request->input('b')));

            $row = \Illuminate\Support\Facades\DB::table('users')
                ->where('username', $username)
                ->where('password', $password)
                ->where('blokir', 'N')
                ->first();

            if ($row) {
                session([
                    'upload_image_file_manager' => true,
                    'username' => $row->username,
                    'level' => $row->level,
                    'id_session' => $row->id_session,
                ]);

                if ($row->level == 'admin') {
                    return redirect('admin/dashboard');
                } else {
                    // Just in case, redirect non-admins back or to their user profile
                    return redirect('user/profile');
                }
            } else {
                $title = 'Username atau Password salah!';
                return view('admin.login', compact('title'));
            }
        }

        $title = 'Administrator &rsaquo; Log In';
        return view('admin.login', compact('title'));
    }

    public function home()
    {
        $total_konsultasi = \Illuminate\Support\Facades\DB::table('konsul')->count();
        $pesan_masuk = \Illuminate\Support\Facades\DB::table('hubungi')->count();
        $total_berita = \Illuminate\Support\Facades\DB::table('berita')->count();
        $total_pengguna = \Illuminate\Support\Facades\DB::table('users')->where('level', 'user')->count();
        
        return view('admin.home', compact('total_konsultasi', 'pesan_masuk', 'total_berita', 'total_pengguna'));
    }

    /**
     * Admin dashboard overview
     */
    public function dashboard()
    {
        // Totals
        $total_users = \Illuminate\Support\Facades\DB::table('users')->where('level', 'user')->count();
        $total_psikolog = \Illuminate\Support\Facades\DB::table('users')->where('level', 'psikolog')->count();
        $active_consultations = \Illuminate\Support\Facades\DB::table('konsul')->where('status', 'aktif')->count();

        // Recent activities (limit 5)
        $recent_notes = \Illuminate\Support\Facades\DB::table('clinical_notes')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        $recent_consultations = \Illuminate\Support\Facades\DB::table('konsul')
            ->orderBy('tanggal', 'desc')
            ->limit(5)
            ->get();

        // Chart data: consultations per day for last 7 days
        $chart = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $count = \Illuminate\Support\Facades\DB::table('konsul')
                ->whereDate('tanggal', $date)
                ->count();
            $chart['labels'][] = $date;
            $chart['data'][] = $count;
        }

        return view('admin.dashboard', [
            'total_users' => $total_users,
            'total_psikolog' => $total_psikolog,
            'active_consultations' => $active_consultations,
            'recent_notes' => $recent_notes,
            'recent_consultations' => $recent_consultations,
            'chart' => $chart,
        ]);
    }

    public function logout()
    {
        session()->flush();
        return redirect('admin');
    }

    // ========================
    // MANAJEMEN USER (WARGA)
    // ========================
    public function manajemenuser()
    {
        $title = 'Manajemen User';
        $users = \Illuminate\Support\Facades\DB::table('users')->where('level', 'user')->get();
        return view('admin.users.index', compact('title', 'users'));
    }

    public function tambah_manajemenuser(Request $request)
    {
        if ($request->isMethod('post')) {
            $username = $request->input('username');
            
            $cek = \Illuminate\Support\Facades\DB::table('users')->where('username', $username)->first();
            if ($cek) {
                return redirect()->back()->withInput()->with('message', '<div class="alert alert-danger">Username sudah digunakan!</div>');
            }

            \Illuminate\Support\Facades\DB::table('users')->insert([
                'username' => $username,
                'password' => \Illuminate\Support\Facades\Hash::make($request->input('password')),
                'nama_lengkap' => $request->input('nama_lengkap'),
                'email' => $request->input('email'),
                'no_telp' => $request->input('no_telp'),
                'jenis_kelamin' => '',
                'alamat_lengkap' => '',
                'tempat_lahir' => '',
                'tanggal_lahir' => date('Y-m-d'),
                'status_kawin' => '',
                'agama' => '',
                'perangkat_daerah' => '',
                'foto' => '',
                'level' => 'user',
                'blokir' => 'N',
                'id_session' => md5($username . time())
            ]);

            return redirect('admin/manajemenuser')->with('message', '<div class="alert alert-success">Berhasil menambahkan pengguna baru.</div>');
        }

        $title = 'Tambah Pengguna Baru';
        return view('admin.users.tambah', compact('title'));
    }

    public function delete_manajemenuser($id)
    {
        \Illuminate\Support\Facades\DB::table('users')->where('username', $id)->where('level', 'user')->delete();
        return redirect('admin/manajemenuser')->with('message', '<div class="alert alert-success">Data pengguna berhasil dihapus.</div>');
    }

    // ========================
    // MANAJEMEN PSIKOLOG
    // ========================
    public function manajemen_psikolog()
    {
        $title = 'Manajemen Psikolog';
        $psikologs = \Illuminate\Support\Facades\DB::table('users')->where('level', 'psikolog')->get();
        return view('admin.psikolog.index', compact('title', 'psikologs'));
    }

    public function tambah_psikolog(Request $request)
    {
        if ($request->isMethod('post')) {
            $username = $request->input('username');
            
            $cek = \Illuminate\Support\Facades\DB::table('users')->where('username', $username)->first();
            if ($cek) {
                return redirect()->back()->withInput()->with('message', '<div class="alert alert-danger">Username sudah digunakan!</div>');
            }

            \Illuminate\Support\Facades\DB::table('users')->insert([
                'username' => $username,
                'password' => \Illuminate\Support\Facades\Hash::make($request->input('password')),
                'nama_lengkap' => $request->input('nama_lengkap'),
                'email' => $request->input('email'),
                'no_telp' => $request->input('no_telp'),
                'jenis_kelamin' => '',
                'alamat_lengkap' => '',
                'tempat_lahir' => '',
                'tanggal_lahir' => date('Y-m-d'),
                'status_kawin' => '',
                'agama' => '',
                'perangkat_daerah' => '',
                'foto' => '',
                'level' => 'psikolog',
                'blokir' => 'N',
                'id_session' => md5($username . time())
            ]);

            return redirect('admin/manajemen_psikolog')->with('message', '<div class="alert alert-success">Berhasil menambahkan psikolog baru.</div>');
        }

        $title = 'Tambah Psikolog Baru';
        return view('admin.psikolog.tambah', compact('title'));
    }

    public function delete_psikolog($username)
    {
        \Illuminate\Support\Facades\DB::table('users')->where('username', $username)->where('level', 'psikolog')->delete();
        return redirect('admin/manajemen_psikolog')->with('message', '<div class="alert alert-success">Data psikolog berhasil dihapus.</div>');
    }

    // ========================
    // MANAJEMEN KATEGORI BERITA
    // ========================
    public function kategoriberita()
    {
        $title = 'Manajemen Kategori Berita';
        $kategori = \Illuminate\Support\Facades\DB::table('kategori')->orderBy('id_kategori', 'DESC')->paginate(10);
        return view('admin.kategori.index', compact('title', 'kategori'));
    }

    public function tambah_kategoriberita(Request $request)
    {
        if ($request->isMethod('post')) {
            \Illuminate\Support\Facades\DB::table('kategori')->insert([
                'nama_kategori' => $request->input('a'),
                'username' => session('username'),
                'kategori_seo' => \Illuminate\Support\Str::slug($request->input('a')),
                'aktif' => $request->input('b'),
                'sidebar' => $request->input('c', 0)
            ]);
            return redirect('admin/kategoriberita')->with('message', '<div class="alert alert-success">Berhasil menambahkan kategori berita.</div>');
        }

        $title = 'Tambah Kategori Berita';
        return view('admin.kategori.tambah', compact('title'));
    }

    public function edit_kategoriberita(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            \Illuminate\Support\Facades\DB::table('kategori')->where('id_kategori', $id)->update([
                'nama_kategori' => $request->input('a'),
                'username' => session('username'),
                'kategori_seo' => \Illuminate\Support\Str::slug($request->input('a')),
                'aktif' => $request->input('b'),
                'sidebar' => $request->input('c', 0)
            ]);
            return redirect('admin/kategoriberita')->with('message', '<div class="alert alert-success">Berhasil mengubah kategori berita.</div>');
        }

        $title = 'Edit Kategori Berita';
        $rows = \Illuminate\Support\Facades\DB::table('kategori')->where('id_kategori', $id)->first();
        return view('admin.kategori.edit', compact('title', 'rows'));
    }

    public function delete_kategoriberita($id)
    {
        \Illuminate\Support\Facades\DB::table('kategori')->where('id_kategori', $id)->delete();
        return redirect('admin/kategoriberita')->with('message', '<div class="alert alert-success">Kategori berhasil dihapus.</div>');
    }

    // ========================
    // MANAJEMEN BERITA
    // ========================
    public function listberita()
    {
        $title = 'Manajemen Berita';
        $berita = \Illuminate\Support\Facades\DB::table('berita')
            ->join('kategori', 'berita.id_kategori', '=', 'kategori.id_kategori')
            ->select('berita.*', 'kategori.nama_kategori')
            ->orderBy('id_berita', 'DESC')
            ->paginate(10);
        return view('admin.berita.index', compact('title', 'berita'));
    }

    public function tambah_listberita(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = [
                'id_kategori' => $request->input('a'),
                'username' => session('username'),
                'judul' => $request->input('b'),
                'sub_judul' => $request->input('c', ''),
                'youtube' => $request->input('d', ''),
                'judul_seo' => \Illuminate\Support\Str::slug($request->input('b')),
                'headline' => $request->input('e', 'N'),
                'aktif' => $request->input('f', 'Y'),
                'utama' => $request->input('g', 'N'),
                'isi_berita' => $request->input('h'),
                'keterangan_gambar' => $request->input('i', ''),
                'hari' => \App\Helpers\Tanggal::hari_ini(date('w')),
                'tanggal' => date('Y-m-d'),
                'jam' => date('H:i:s'),
                'dibaca' => 0,
                'tag' => $request->input('j', ''),
                'status' => 'Y'
            ];

            if ($request->hasFile('k')) {
                $file = $request->file('k');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('asset/foto_berita'), $filename);
                $data['gambar'] = $filename;
            } else {
                $data['gambar'] = '';
            }

            \Illuminate\Support\Facades\DB::table('berita')->insert($data);
            return redirect('admin/listberita')->with('message', '<div class="alert alert-success">Berhasil menambahkan berita.</div>');
        }

        $title = 'Tambah Berita';
        $kategori = \Illuminate\Support\Facades\DB::table('kategori')->get();
        return view('admin.berita.tambah', compact('title', 'kategori'));
    }

    public function edit_listberita(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = [
                'id_kategori' => $request->input('a'),
                'username' => session('username'),
                'judul' => $request->input('b'),
                'sub_judul' => $request->input('c', ''),
                'youtube' => $request->input('d', ''),
                'judul_seo' => \Illuminate\Support\Str::slug($request->input('b')),
                'headline' => $request->input('e', 'N'),
                'aktif' => $request->input('f', 'Y'),
                'utama' => $request->input('g', 'N'),
                'isi_berita' => $request->input('h'),
                'keterangan_gambar' => $request->input('i', ''),
                'tag' => $request->input('j', '')
            ];

            if ($request->hasFile('k')) {
                $file = $request->file('k');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('asset/foto_berita'), $filename);
                $data['gambar'] = $filename;
            }

            \Illuminate\Support\Facades\DB::table('berita')->where('id_berita', $id)->update($data);
            return redirect('admin/listberita')->with('message', '<div class="alert alert-success">Berhasil mengubah berita.</div>');
        }

        $title = 'Edit Berita';
        $rows = \Illuminate\Support\Facades\DB::table('berita')->where('id_berita', $id)->first();
        $kategori = \Illuminate\Support\Facades\DB::table('kategori')->get();
        return view('admin.berita.edit', compact('title', 'rows', 'kategori'));
    }

    public function delete_listberita($id)
    {
        \Illuminate\Support\Facades\DB::table('berita')->where('id_berita', $id)->delete();
        return redirect('admin/listberita')->with('message', '<div class="alert alert-success">Berita berhasil dihapus.</div>');
    }

    public function publish_listberita($id, $status)
    {
        \Illuminate\Support\Facades\DB::table('berita')->where('id_berita', $id)->update(['status' => $status]);
        return redirect('admin/listberita')->with('message', '<div class="alert alert-success">Status berita berhasil diubah.</div>');
    }

    // ========================
    // MANAJEMEN KOMENTAR BERITA
    // ========================
    public function komentarberita()
    {
        $title = 'Manajemen Komentar Berita';
        $komentar = \Illuminate\Support\Facades\DB::table('komentar')
            ->join('berita', 'komentar.id_berita', '=', 'berita.id_berita')
            ->select('komentar.*', 'berita.judul')
            ->orderBy('id_komentar', 'DESC')
            ->paginate(10);
        return view('admin.komentar.index', compact('title', 'komentar'));
    }

    public function edit_komentarberita(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            \Illuminate\Support\Facades\DB::table('komentar')->where('id_komentar', $id)->update([
                'nama_komentar' => $request->input('a'),
                'url' => $request->input('b', ''),
                'isi_komentar' => $request->input('c'),
                'aktif' => $request->input('d'),
                'email' => $request->input('e', '')
            ]);
            return redirect('admin/komentarberita')->with('message', '<div class="alert alert-success">Komentar berhasil diedit.</div>');
        }

        $title = 'Edit Komentar Berita';
        $rows = \Illuminate\Support\Facades\DB::table('komentar')->where('id_komentar', $id)->first();
        return view('admin.komentar.edit', compact('title', 'rows'));
    }

    public function delete_komentarberita($id)
    {
        \Illuminate\Support\Facades\DB::table('komentar')->where('id_komentar', $id)->delete();
        return redirect('admin/komentarberita')->with('message', '<div class="alert alert-success">Komentar berhasil dihapus.</div>');
    }
}

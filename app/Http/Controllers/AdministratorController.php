<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdministratorController extends Controller
{
    public function index(Request $request)
    {
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
                    return redirect('admin/home');
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
        return view('admin.home');
    }

    public function logout()
    {
        session()->flush();
        return redirect('admin');
    }
}

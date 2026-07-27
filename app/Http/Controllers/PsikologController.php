<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PsikologController extends Controller
{
    public function lists()
    {
        $title = 'Psikolog Kami';
        $description = description();
        $keywords = keywords();
        
        $psikolog = DB::table('users')
            ->where('level', 'psikolog') 
            ->orderBy('id_session', 'DESC')
            ->paginate(10);
            
        return view('psikolog.list', compact('title', 'description', 'keywords', 'psikolog'));
    }
}

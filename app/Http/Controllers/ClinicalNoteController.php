<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClinicalNoteController extends Controller
{
    public function index()
    {
        $notes = \App\Models\ClinicalNote::orderBy('created_at', 'desc')->get();
        return view('psikolog.clinical_notes.index', compact('notes'));
    }

    public function create()
    {
        $patients = \Illuminate\Support\Facades\DB::table('konsul')
            ->leftJoin('users', 'konsul.username', '=', 'users.username')
            ->select('users.username', 'users.nama_lengkap', 'users.tanggal_lahir')
            ->where('konsul.username_psikolog', session('username'))
            ->whereNotNull('users.username')
            ->distinct()
            ->get();
            
        return view('psikolog.clinical_notes.create', compact('patients'));
    }

    public function store(\App\Http\Requests\StoreClinicalNoteRequest $request)
    {
        \App\Models\ClinicalNote::create($request->validated());
        return redirect()->route('psikolog.clinical_notes.index')->with('success', 'Clinical Note berhasil ditambahkan.');
    }

    public function show($id)
    {
        $note = \App\Models\ClinicalNote::findOrFail($id);
        return view('psikolog.clinical_notes.show', compact('note'));
    }

    public function edit($id)
    {
        $note = \App\Models\ClinicalNote::findOrFail($id);
        
        $patients = \Illuminate\Support\Facades\DB::table('konsul')
            ->leftJoin('users', 'konsul.username', '=', 'users.username')
            ->select('users.username', 'users.nama_lengkap', 'users.tanggal_lahir')
            ->where('konsul.username_psikolog', session('username'))
            ->whereNotNull('users.username')
            ->distinct()
            ->get();
            
        return view('psikolog.clinical_notes.edit', compact('note', 'patients'));
    }

    public function update(\App\Http\Requests\StoreClinicalNoteRequest $request, $id)
    {
        $note = \App\Models\ClinicalNote::findOrFail($id);
        $note->update($request->validated());
        return redirect()->route('psikolog.clinical_notes.index')->with('success', 'Clinical Note berhasil diupdate.');
    }

    public function destroy($id)
    {
        $note = \App\Models\ClinicalNote::findOrFail($id);
        $note->delete();
        return redirect()->route('psikolog.clinical_notes.index')->with('success', 'Clinical Note berhasil dihapus.');
    }
}

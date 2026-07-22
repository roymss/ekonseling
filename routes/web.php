<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\BeritaController;
use App\Http\Controllers\HalamanController;
use App\Http\Controllers\HubungiController;
use App\Http\Controllers\KonsultasiController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\UserController;

// ========================
// Frontend Routes
// ========================
Route::get('/', [MainController::class, 'index'])->name('home');

// Berita
Route::get('/berita', [BeritaController::class, 'index'])->name('berita.index');
Route::get('/berita/detail/{slug}', [BeritaController::class, 'detail'])->name('berita.detail');
Route::post('/berita/kirim_komentar', [BeritaController::class, 'kirim_komentar'])->name('berita.komentar');

// Halaman & Kategori
Route::get('/halaman/detail/{slug}', [HalamanController::class, 'detail'])->name('halaman.detail');
Route::get('/kategori/detail/{slug}', [KategoriController::class, 'detail'])->name('kategori.detail');

// Hubungi Kami
Route::get('/hubungi', [HubungiController::class, 'index'])->name('hubungi.index');
Route::post('/hubungi/kirim', [HubungiController::class, 'kirim'])->name('hubungi.kirim');

// Konsultasi Frontend
Route::get('/konsultasi', [KonsultasiController::class, 'detail'])->name('konsultasi.index'); // as per CI, no index, only detail
Route::get('/konsultasi/detail/{slug}', [KonsultasiController::class, 'detail'])->name('konsultasi.detail');
Route::post('/konsultasi/kirim_komentar', [KonsultasiController::class, 'kirim_komentar'])->name('konsultasi.kirim_komentar');

// Main / Home Alternative (from CI)
Route::get('/main', [MainController::class, 'index']);

// Psikolog Frontend
Route::get('/psikolog/lists', [\App\Http\Controllers\PsikologController::class, 'lists'])->name('psikolog.lists');

// Download
Route::get('/download', [DownloadController::class, 'index'])->name('download.index');
Route::get('/download/file/{id}', [DownloadController::class, 'file'])->name('download.file');

// ========================
// User Member Area Routes
// ========================
Route::prefix('user')->group(function () {
    Route::match(['get', 'post'], '/', [UserController::class, 'index'])->name('user.index');
    Route::match(['get', 'post'], '/login', [UserController::class, 'login'])->name('user.login');
    Route::match(['get', 'post'], '/pendaftaran', [UserController::class, 'pendaftaran'])->name('user.pendaftaran');

    // Protected User Routes
    Route::middleware(['cek_session_user'])->group(function () {
        Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
        Route::match(['get', 'post'], '/edit_profile', [UserController::class, 'edit_profile'])->name('user.edit_profile');
        Route::match(['get', 'post'], '/foto', [UserController::class, 'foto'])->name('user.foto');
        
        Route::get('/konsultasi', [UserController::class, 'konsultasi'])->name('user.konsultasi');
        Route::match(['get', 'post'], '/konsultasi_tambah', [UserController::class, 'konsultasi_tambah'])->name('user.konsultasi_tambah');
        Route::match(['get', 'post'], '/konsultasi_edit/{id}', [UserController::class, 'konsultasi_edit'])->name('user.konsultasi_edit');
        Route::get('/konsultasi_delete/{id}', [UserController::class, 'konsultasi_delete'])->name('user.konsultasi_delete');
        
        Route::get('/logout', [UserController::class, 'logout'])->name('user.logout');
    });
});

// ========================
// Administrator Routes
// ========================
Route::prefix('admin')->group(function () {
    Route::match(['get', 'post'], '/', [AdministratorController::class, 'index'])->name('admin.login');
    Route::match(['get', 'post'], '/reset_password', [AdministratorController::class, 'reset_password'])->name('admin.reset_password');
    Route::match(['get', 'post'], '/lupapassword', [AdministratorController::class, 'lupapassword'])->name('admin.lupapassword');

    // Protected Admin Routes
    Route::middleware(['cek_session_admin'])->group(function () {
        Route::match(['get', 'post'], '/home', [AdministratorController::class, 'home'])->name('admin.home');
        
        // Modul Berita
        Route::get('/listberita', [AdministratorController::class, 'listberita'])->name('admin.listberita');
        Route::match(['get', 'post'], '/tambah_listberita', [AdministratorController::class, 'tambah_listberita'])->name('admin.tambah_listberita');
        Route::match(['get', 'post'], '/edit_listberita/{id}', [AdministratorController::class, 'edit_listberita'])->name('admin.edit_listberita');
        Route::get('/delete_listberita/{id}', [AdministratorController::class, 'delete_listberita'])->name('admin.delete_listberita');
        Route::get('/publish_listberita/{id}/{status}', [AdministratorController::class, 'publish_listberita'])->name('admin.publish_listberita');
        
        // Kategori Berita
        Route::get('/kategoriberita', [AdministratorController::class, 'kategoriberita'])->name('admin.kategoriberita');
        Route::match(['get', 'post'], '/tambah_kategoriberita', [AdministratorController::class, 'tambah_kategoriberita'])->name('admin.tambah_kategoriberita');
        Route::match(['get', 'post'], '/edit_kategoriberita/{id}', [AdministratorController::class, 'edit_kategoriberita'])->name('admin.edit_kategoriberita');
        Route::get('/delete_kategoriberita/{id}', [AdministratorController::class, 'delete_kategoriberita'])->name('admin.delete_kategoriberita');
        
        // Komentar Berita
        Route::get('/komentarberita', [AdministratorController::class, 'komentarberita'])->name('admin.komentarberita');
        Route::match(['get', 'post'], '/edit_komentarberita/{id}', [AdministratorController::class, 'edit_komentarberita'])->name('admin.edit_komentarberita');
        Route::get('/delete_komentarberita/{id}', [AdministratorController::class, 'delete_komentarberita'])->name('admin.delete_komentarberita');

        // Modul Halaman
        Route::get('/halamanbaru', [AdministratorController::class, 'halamanbaru'])->name('admin.halamanbaru');
        Route::match(['get', 'post'], '/tambah_halamanbaru', [AdministratorController::class, 'tambah_halamanbaru'])->name('admin.tambah_halamanbaru');
        Route::match(['get', 'post'], '/edit_halamanbaru/{id}', [AdministratorController::class, 'edit_halamanbaru'])->name('admin.edit_halamanbaru');
        Route::get('/delete_halamanbaru/{id}', [AdministratorController::class, 'delete_halamanbaru'])->name('admin.delete_halamanbaru');

        Route::get('/kategorihalaman', [AdministratorController::class, 'kategorihalaman'])->name('admin.kategorihalaman');
        Route::match(['get', 'post'], '/tambah_kategorihalaman', [AdministratorController::class, 'tambah_kategorihalaman'])->name('admin.tambah_kategorihalaman');
        Route::match(['get', 'post'], '/edit_kategorihalaman/{id}', [AdministratorController::class, 'edit_kategorihalaman'])->name('admin.edit_kategorihalaman');
        Route::get('/delete_kategorihalaman/{id}', [AdministratorController::class, 'delete_kategorihalaman'])->name('admin.delete_kategorihalaman');

        // Pengaturan Website (Menu, Identitas, dll)
        Route::match(['get', 'post'], '/identitaswebsite', [AdministratorController::class, 'identitaswebsite'])->name('admin.identitaswebsite');
        Route::get('/menuwebsite', [AdministratorController::class, 'menuwebsite'])->name('admin.menuwebsite');
        Route::match(['get', 'post'], '/tambah_menuwebsite', [AdministratorController::class, 'tambah_menuwebsite'])->name('admin.tambah_menuwebsite');
        Route::match(['get', 'post'], '/edit_menuwebsite/{id}', [AdministratorController::class, 'edit_menuwebsite'])->name('admin.edit_menuwebsite');
        Route::get('/delete_menuwebsite/{id}', [AdministratorController::class, 'delete_menuwebsite'])->name('admin.delete_menuwebsite');
        
        // Download
        Route::get('/download', [AdministratorController::class, 'download'])->name('admin.download');
        Route::match(['get', 'post'], '/tambah_download', [AdministratorController::class, 'tambah_download'])->name('admin.tambah_download');
        Route::match(['get', 'post'], '/edit_download/{id}', [AdministratorController::class, 'edit_download'])->name('admin.edit_download');
        Route::get('/delete_download/{id}', [AdministratorController::class, 'delete_download'])->name('admin.delete_download');

        // Pesan Masuk
        Route::get('/pesanmasuk', [AdministratorController::class, 'pesanmasuk'])->name('admin.pesanmasuk');
        Route::match(['get', 'post'], '/detail_pesanmasuk/{id}', [AdministratorController::class, 'detail_pesanmasuk'])->name('admin.detail_pesanmasuk');
        Route::get('/delete_pesanmasuk/{id}', [AdministratorController::class, 'delete_pesanmasuk'])->name('admin.delete_pesanmasuk');

        // Manajemen User
        Route::get('/manajemenuser', [AdministratorController::class, 'manajemenuser'])->name('admin.manajemenuser');
        Route::match(['get', 'post'], '/tambah_manajemenuser', [AdministratorController::class, 'tambah_manajemenuser'])->name('admin.tambah_manajemenuser');
        Route::match(['get', 'post'], '/edit_manajemenuser/{id}', [AdministratorController::class, 'edit_manajemenuser'])->name('admin.edit_manajemenuser');
        Route::get('/delete_manajemenuser/{id}', [AdministratorController::class, 'delete_manajemenuser'])->name('admin.delete_manajemenuser');
        
        // Modul Konsultasi (Admin)
        Route::get('/konsul', [AdministratorController::class, 'konsul'])->name('admin.konsul');
        Route::get('/delete_konsul/{id}', [AdministratorController::class, 'delete_konsul'])->name('admin.delete_konsul');
        Route::get('/kategori_konsul', [AdministratorController::class, 'kategori_konsul'])->name('admin.kategori_konsul');
        Route::match(['get', 'post'], '/tambah_kategori_konsul', [AdministratorController::class, 'tambah_kategori_konsul'])->name('admin.tambah_kategori_konsul');
        Route::match(['get', 'post'], '/edit_kategori_konsul/{id}', [AdministratorController::class, 'edit_kategori_konsul'])->name('admin.edit_kategori_konsul');
        Route::get('/delete_kategori_konsul/{id}', [AdministratorController::class, 'delete_kategori_konsul'])->name('admin.delete_kategori_konsul');
        Route::get('/komentar_konsul', [AdministratorController::class, 'komentar_konsul'])->name('admin.komentar_konsul');
        Route::get('/publish_komentar_konsul/{id}/{status}', [AdministratorController::class, 'publish_komentar_konsul'])->name('admin.publish_komentar_konsul');
        Route::get('/delete_komentar_konsul/{id}', [AdministratorController::class, 'delete_komentar_konsul'])->name('admin.delete_komentar_konsul');
        Route::get('/publish_konsul/{id}/{status}', [AdministratorController::class, 'publish_konsul'])->name('admin.publish_konsul');

        Route::get('/logout', [AdministratorController::class, 'logout'])->name('admin.logout');
    });
});

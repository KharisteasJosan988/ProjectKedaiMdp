<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\GaleriController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schedule;
use PgSql\Result;

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/', [AuthController::class, 'index'])->name('auth.index');
Route::post('/auth/verify', [AuthController::class, 'verify'])->name('auth.verify');

Route::get('/login', [AuthController::class, 'index'])->name('login');

// Rute untuk menampilkan formulir pendaftaran
Route::get('/register', [RegisterController::class, 'formRegister'])->name('register');
// Rute untuk memproses pendaftaran
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth'])->group(function () {
    Route::get('/user/dashboard', [DashboardController::class, 'user'])->name('user.dashboard.index');
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard.index');
});

Route::get('/auth/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::group(['middleware' => 'auth:admin'], function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard.index');
});

Route::group(['middleware' => 'auth:user'], function () {
    Route::get('/user/dashboard', [DashboardController::class, 'user'])->name('user.dashboard.index');
});

Route::get('/contact', [ContactController::class, 'index'])->name('contact.index');
Route::get('/form-tambah-contact', [ContactController::class, 'formTambah'])->name('contact.formTambah');
Route::post('/contact/tambah', [ContactController::class, 'prosesTambah'])->name('contact.prosesTambah');
Route::get('/contact/{id}/edit', [ContactController::class, 'edit'])->name('contact.edit');
Route::put('/contact/update/{id}', [ContactController::class, 'update'])->name('contact.update');
Route::delete('/contact/{id}', [ContactController::class, 'hapus'])->name('contact.hapus');

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/form-tambah', [MenuController::class, 'formTambah'])->name('menu.formTambah');
Route::post('/menu/tambah', [MenuController::class, 'prosesTambah'])->name('menu.prosesTambah');
Route::get('/menu/{id}/ubah', [MenuController::class, 'formUbah'])->name('menu.formUbah');
Route::post('/menu/ubah/{id}', [MenuController::class, 'prosesUbah'])->name('menu.prosesUbah');
Route::delete('/menu/{id}', [MenuController::class, 'hapus'])->name('menu.hapus');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/form-tambah-cart', [CartController::class, 'formTambah'])->name('cart.formTambah');
Route::post('/cart/tambah', [CartController::class, 'prosesTambah'])->name('cart.prosesTambah');
Route::get('/cart/{id}/ubah', [CartController::class, 'formUbah'])->name('cart.formUbah');
Route::post('/cart/ubah/{id}', [CartController::class, 'prosesUbah'])->name('cart.prosesUbah');
Route::delete('/cart/{id}', [CartController::class, 'hapus'])->name('cart.hapus');

Route::get('/forgot-password', [PasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [PasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [PasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [PasswordController::class, 'reset'])->name('password.update');

Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
Route::get('/galeri/create', [GaleriController::class, 'formTambahGaleri'])->name('galeri.formTambah');
Route::post('/galeri/store', [GaleriController::class, 'prosesTambahGaleri'])->name('galeri.prosesTambah');
Route::get('/galeri/edit/{id}', [GaleriController::class, 'ubahGaleri'])->name('galeri.formUbah');
Route::put('/galeri/update/{id}', [GaleriController::class, 'prosesUbahGaleri'])->name('galeri.prosesUbah');
Route::delete('/galeri/delete/{id}', [GaleriController::class, 'hapus'])->name('galeri.hapus');



















Route::get('/upload', [UploadController::class, 'form'])->name('upload.form');
Route::post('/upload', [UploadController::class, 'proses'])->name('upload.proses');

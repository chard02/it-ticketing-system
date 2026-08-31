<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\SubUnitController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\DivisiController;
use App\Http\Controllers\Admin\JabatanController;
use App\Http\Controllers\Admin\LevelController;
use App\Http\Controllers\Pegawai\TiketController;
use App\Http\Controllers\Admin\TiketController as AdminTiketController;
use App\Http\Controllers\Teknisi\TiketController as TeknisiTiketController;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('guest')->group(function () {

    Route::get('/login', [LoginController::class, 'index'])
        ->name('login');

    Route::post('/login', [LoginController::class, 'login'])
        ->name('login.proses');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/logout', [LoginController::class, 'logout'])
        ->name('logout');
});


use App\Http\Controllers\NotificationController;

Route::middleware('auth')->group(function () {

    Route::get(
        '/notifications',
        [NotificationController::class, 'index']
    )->name('notifications.index');


    Route::post(
        '/notifications/{notification}/read',
        [NotificationController::class, 'read']
    )->name('notifications.read');


    Route::post(
        '/notifications/read-all',
        [NotificationController::class, 'readAll']
    )->name('notifications.read-all');
});



//Admin
Route::middleware('auth')->group(function () {
    Route::resource('pegawai', PegawaiController::class);
    Route::resource('unit', UnitController::class)
        ->except('show');
    Route::resource('sub-unit', SubUnitController::class);
    Route::resource('jabatan', JabatanController::class);
    Route::resource('divisi', DivisiController::class);
    Route::resource('level', LevelController::class);
});

Route::middleware('auth')->group(function () {

    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::resource('tiket', AdminTiketController::class)
                ->only([
                    'index',
                    'show',
                ]);

            Route::put(
                'tiket/{tiket}/assign',
                [
                    \App\Http\Controllers\Admin\TiketController::class,
                    'assign'
                ]
            )->name('tiket.assign');

            Route::put(
                '/tiket/{tiket}/approve-konfirmasi',
                [\App\Http\Controllers\Admin\TiketController::class, 'approveKonfirmasi']
            )->name('tiket.approve-konfirmasi');


            Route::put(
                '/tiket/{tiket}/buka-kembali',
                [\App\Http\Controllers\Admin\TiketController::class, 'bukaKembali']
            )->name('tiket.buka-kembali');

            Route::resource(
                'jenis-tiket',
                \App\Http\Controllers\Admin\JenisTiketController::class
            );

            Route::resource(
                'kategori-tiket',
                \App\Http\Controllers\Admin\KategoriTiketController::class
            );

            Route::resource(
                'sub-kategori-tiket',
                \App\Http\Controllers\Admin\SubKategoriTiketController::class
            );
        });
});


// Pegawai
Route::middleware('auth')->group(function () {
    Route::prefix('pegawai/tiket')
        ->name('pegawai.')
        ->group(function () {
            Route::resource('tiket', TiketController::class)
                ->only([
                    'index',
                    'create',
                    'store',
                    'show',
                ]);
        });
});

use App\Http\Controllers\Pegawai\TiketController as PegawaiTiketController;

Route::middleware(['auth'])
    ->prefix('pegawai')
    ->name('pegawai.')
    ->group(function () {

        Route::get(
            '/tiket/{tiket}',
            [PegawaiTiketController::class, 'show']
        )->name('tiket.show');

        Route::put(
            '/tiket/{tiket}/konfirmasi',
            [TiketController::class, 'konfirmasi']
        )->name('tiket.konfirmasi');

        Route::put(
            '/pegawai/tiket/{tiket}/konfirmasi',
            [PegawaiTiketController::class, 'konfirmasi']
        )->name('pegawai.tiket.konfirmasi');
    });


// Teknisi
Route::middleware('auth')
    ->prefix('teknisi')
    ->name('teknisi.')
    ->group(function () {

        Route::resource('tiket', TeknisiTiketController::class)
            ->only([
                'index',
                'show',
            ]);
    });

Route::middleware('auth')
    ->prefix('teknisi')
    ->name('teknisi.')
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');
    });


Route::middleware('auth')->prefix('teknisi')->name('teknisi.')->group(function () {

    Route::get(
        '/tiket/{tiket}',
        [TeknisiTiketController::class, 'show']
    )->name('tiket.show');

    Route::put(
        '/tiket/{tiket}/update-status',
        [TeknisiTiketController::class, 'updateStatus']
    )->name('tiket.update-status');
});

Route::middleware('auth')->prefix('teknisi')->name('teknisi.')->group(function () {

    Route::get(
        '/tiket/{tiket}',
        [TeknisiTiketController::class, 'show']
    )->name('tiket.show');


    Route::put(
        '/tiket/{tiket}/status',
        [TeknisiTiketController::class, 'updateStatus']
    )->name('tiket.update-status');
});

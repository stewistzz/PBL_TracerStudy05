<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfesiController;
use App\Http\Controllers\KategoriProfesiController;
use App\Http\Controllers\KategoriPertanyaanController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\AlumniTracerController;
use App\Http\Controllers\TracerStudyController;
use App\Http\Controllers\KesesuaianPekerjaanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataPenggunaController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\KepuasanController;
use App\Http\Controllers\AdminController;

// route landingpage
Route::get('/', function () {
    return view('landing_page');
});

// Auth Routes 
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// forgot password
Route::get('/reset-password', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'processReset'])->name('password.process');

// Survey Routes (untuk pengguna_lulusan mengisi survei via token)
Route::prefix('survey')->name('survey.')->group(function () {
    Route::get('/access/{token}', [App\Http\Controllers\SurveyController::class, 'accessSurvey'])->name('access');
    Route::post('/access/{token}', [App\Http\Controllers\SurveyController::class, 'submitSurvey'])->name('submit');
    Route::get('/invalid', function () {
        return view('survey.survey_invalid')->with('error', session('error'));
    })->name('invalid');
    Route::get('/success', function () {
        return view('survey.survey_success')->with('success', session('success'));
    })->name('success');
});

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Admin Routes
    Route::middleware(['check.role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');

        // Profesi Routes
        Route::prefix('profesi')->name('profesi.')->group(function () {
            Route::get('/', [ProfesiController::class, 'index'])->name('index');
            Route::get('/list', [ProfesiController::class, 'list'])->name('list');

            // AJAX Routes
            Route::get('/create_ajax', [ProfesiController::class, 'create_ajax'])->name('create_ajax');
            Route::post('/ajax', [ProfesiController::class, 'store_ajax'])->name('store_ajax');
            Route::get('/{id}/edit_ajax', [ProfesiController::class, 'edit_ajax'])->name('edit_ajax');
            Route::post('/{id}/update_ajax', [ProfesiController::class, 'update_ajax'])->name('update_ajax');

            // Delete Routes
            Route::get('/{id}/delete_ajax', [ProfesiController::class, 'confirm_ajax'])->name('confirm_ajax');
            Route::delete('/{id}/delete_ajax', [ProfesiController::class, 'delete_ajax'])->name('delete_ajax');
            Route::delete('/{id}', [ProfesiController::class, 'destroy'])->name('destroy');
        });

        // Kategori Profesi Routes
        Route::prefix('kategori_profesi')->name('kategori_profesi.')->group(function () {
            Route::get('/', [KategoriProfesiController::class, 'index'])->name('index');
            Route::get('/list', [KategoriProfesiController::class, 'list'])->name('list');
            Route::get('/create', [KategoriProfesiController::class, 'create_ajax'])->name('create');
            Route::post('/store', [KategoriProfesiController::class, 'store_ajax'])->name('store');
            Route::get('/edit/{id}', [KategoriProfesiController::class, 'edit_ajax'])->name('edit');
            Route::get('/show/{id}', [KategoriProfesiController::class, 'show_ajax'])->name('show');
            Route::post('/update/{id}', [KategoriProfesiController::class, 'update_ajax'])->name('update');
            //Route::delete('/destroy/{id}', [KategoriProfesiController::class, 'destroy_ajax'])->name('destroy');
            Route::get('/confirm/{id}', [KategoriProfesiController::class, 'confirm_ajax'])->name('confirm');
            Route::delete('/delete/{id}', [KategoriProfesiController::class, 'delete_ajax'])->name('delete');
        });

        // Instansi Routes
        Route::prefix('instansi')->name('instansi.')->group(function () {
            Route::get('/', [InstansiController::class, 'index'])->name('index');
            Route::get('/list', [InstansiController::class, 'list'])->name('list');
            Route::get('/create', [InstansiController::class, 'create_ajax'])->name('create');
            Route::post('/store', [InstansiController::class, 'store_ajax'])->name('store');
            Route::get('/edit/{id}', [InstansiController::class, 'edit_ajax'])->name('edit');
            Route::post('/update/{id}', [InstansiController::class, 'update_ajax'])->name('update');
            //Route::delete('/destroy/{id}', [InstansiController::class, 'destroy_ajax'])->name('destroy');
            Route::get('/confirm/{id}', [InstansiController::class, 'confirm_ajax'])->name('confirm');
            Route::delete('/delete/{id}', [InstansiController::class, 'delete_ajax'])->name('delete');
        });

        Route::prefix('alumni')->name('alumni.')->group(function () {
            Route::get('/', [AlumniController::class, 'index'])->name('index');
            Route::get('/list', [AlumniController::class, 'list'])->name('list');
            Route::get('/create', [AlumniController::class, 'create_ajax'])->name('create');
            Route::post('/store', [AlumniController::class, 'store_ajax'])->name('store');
            Route::get('/edit/{id}', [AlumniController::class, 'edit_ajax'])->name('edit');
            Route::post('/update/{id}', [AlumniController::class, 'update_ajax'])->name('update');
            Route::delete('/destroy/{id}', [AlumniController::class, 'destroy_ajax'])->name('destroy');
            Route::get('/filter', [AlumniController::class, 'filter_ajax'])->name('filter');
            Route::get('/{id}/confirm_ajax', [AlumniController::class, 'confirm_ajax'])->name('confirm_ajax');
            Route::delete('/{id}/delete_ajax', [AlumniController::class, 'delete_ajax'])->name('delete_ajax');
            Route::get('/export_excel', [AlumniController::class, 'export_excel'])->name('export_excel');
            Route::get('/{id}/show_ajax', [AlumniController::class, 'show_ajax'])->name('show_ajax');
        });
        // route untuk admin
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/', [AdminController::class, 'index'])->name('index');
            Route::get('/list', [AdminController::class, 'list'])->name('list');
            Route::get('/create', [AdminController::class, 'create'])->name('create');
            Route::post('/store', [AdminController::class, 'store'])->name('store');
            Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
            Route::post('/update/{id}', [AdminController::class, 'update'])->name('update');
            Route::delete('/destroy/{id}', [AdminController::class, 'destroy_ajax'])->name('destroy');
        });

        // route untuk data pengguna
        Route::prefix('data_pengguna')->name('data_pengguna.')->group(function () {
            Route::get('/', [DataPenggunaController::class, 'index'])->name('index');
            Route::get('/list', [DataPenggunaController::class, 'list'])->name('list');
            Route::get('/create', [DataPenggunaController::class, 'create_ajax'])->name('create');
            Route::post('/store', [DataPenggunaController::class, 'store_ajax'])->name('store');
            Route::get('/edit/{id}', [DataPenggunaController::class, 'edit_ajax'])->name('edit');
            Route::post('/update/{id}', [DataPenggunaController::class, 'update_ajax'])->name('update');
            Route::delete('/destroy/{id}', [DataPenggunaController::class, 'destroy_ajax'])->name('destroy');

            // CRUD Routes
            Route::get('/create_ajax', [DataPenggunaController::class, 'create_ajax'])->name('data_pengguna.create_ajax');
            Route::post('/ajax', [DataPenggunaController::class, 'store_ajax'])->name('data_pengguna.store_ajax');
            Route::get('/{id}/edit_ajax', [DataPenggunaController::class, 'edit_ajax'])->name('data_pengguna.edit_ajax');
            Route::put('/{id}/update_ajax', [DataPenggunaController::class, 'update_ajax'])->name('data_pengguna.update_ajax');
            Route::delete('/{id}/delete_ajax', [DataPenggunaController::class, 'destroy_ajax'])->name('data_pengguna.destroy_ajax');

            // Import Routes
            Route::get('/import', [DataPenggunaController::class, 'import'])->name('import');
            Route::post('/import_ajax', [DataPenggunaController::class, 'import_ajax'])->name('import_ajax');


        // Kepuasan Routes (Admin)
        Route::prefix('kepuasan')->name('kepuasan.')->group(function () {
            Route::get('/', [KepuasanController::class, 'index'])->name('index');
            Route::get('/list', [KepuasanController::class, 'list'])->name('list');
            Route::get('/grafik', [KepuasanController::class, 'grafik'])->name('grafik');
            Route::get('/create', [KepuasanController::class, 'create_ajax'])->name('create');
            Route::post('/store', [KepuasanController::class, 'store_ajax'])->name('store');
            Route::get('/edit/{id}', [KepuasanController::class, 'edit_ajax'])->name('edit');
            Route::post('/update/{id}', [KepuasanController::class, 'update_ajax'])->name('update');
            Route::delete('/destroy/{id}', [KepuasanController::class, 'destroy_ajax'])->name('destroy');
            Route::get('/export-excel', [KepuasanController::class, 'exportExcel'])->name('export-excel');
        });

        // route untuk user
        Route::prefix('user')->name('user.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/list', [UserController::class, 'list'])->name('list');
            Route::get('/create', [UserController::class, 'create_ajax'])->name('create');
            Route::post('/store', [UserController::class, 'store_ajax'])->name('store');
            Route::get('/edit/{id}', [UserController::class, 'edit_ajax'])->name('edit');
            Route::post('/update/{id}', [UserController::class, 'update_ajax'])->name('update');
            Route::delete('/destroy/{id}', [UserController::class, 'destroy_ajax'])->name('destroy');
            // Import
            Route::get('/import', [UserController::class, 'import'])->name('import');
            Route::post('/import_ajax', [UserController::class, 'import_ajax'])->name('import_ajax');
        });


        // route untuk data kesesuaian
        Route::get('/admin/kesesuaian', [KesesuaianPekerjaanController::class, 'index'])->name('admin.kesesuaian');

        // route untuk pertanyaan
        Route::prefix('pertanyaan')->name('pertanyaan.')->group(function () {
            Route::get('/', [PertanyaanController::class, 'index'])->name('index');
            Route::get('/list', [PertanyaanController::class, 'list'])->name('list');

            // AJAX Routes
            Route::get('/create_ajax', [PertanyaanController::class, 'create_ajax'])->name('create_ajax');
            Route::post('/ajax', [PertanyaanController::class, 'store_ajax'])->name('store_ajax');
            Route::get('/{id}/edit_ajax', [PertanyaanController::class, 'edit_ajax'])->name('edit_ajax');
            Route::post('/{id}/update_ajax', [PertanyaanController::class, 'update_ajax'])->name('update_ajax');

            // Delete Routes
            Route::get('/{id}/delete_ajax', [PertanyaanController::class, 'confirm_ajax'])->name('confirm_ajax');
            Route::delete('/{id}/delete_ajax', [PertanyaanController::class, 'delete_ajax'])->name('delete_ajax');
            //Route::delete('/{id}', [PertanyaanController::class, 'destroy'])->name('destroy');
        });
    });


    Route::prefix('kategori_pertanyaan')->name('kategori_pertanyaan.')->group(function () {
        Route::get('/', [KategoriPertanyaanController::class, 'index'])->name('index');
        Route::get('/list', [KategoriPertanyaanController::class, 'list'])->name('list');

        // AJAX Routes
        Route::get('/create_ajax', [KategoriPertanyaanController::class, 'create_ajax'])->name('create_ajax');
        Route::post('/ajax', [KategoriPertanyaanController::class, 'store_ajax'])->name('store_ajax');
        Route::get('/{id}/edit_ajax', [KategoriPertanyaanController::class, 'edit_ajax'])->name('edit_ajax');
        Route::post('/{id}/update_ajax', [KategoriPertanyaanController::class, 'update_ajax'])->name('update_ajax');

        // Delete Routes
        Route::get('/{id}/delete_ajax', [KategoriPertanyaanController::class, 'confirm_ajax'])->name('confirm_ajax');
        Route::delete('/{id}/delete_ajax', [KategoriPertanyaanController::class, 'delete_ajax'])->name('delete_ajax');
        Route::delete('/{id}', [KategoriPertanyaanController::class, 'destroy'])->name('destroy');
    });


    // route untuk alumni_tracer
    // Route::prefix('alumni_tracer')->name('alumni_tracer.')->group(function () {
    //     Route::get('/', [AlumniTracerController::class, 'index'])->name('index');
    //     Route::get('/list', [AlumniTracerController::class, 'list'])->name('list');

    //     // route untuk kirim token
    //     Route::post('/kirim-token/{id}', [AlumniTracerController::class, 'kirimToken'])->name('kirim_token');

    // });

    Route::get('/alumni-tracer', [AlumniTracerController::class, 'index'])->name('alumni_tracer.index');
    Route::get('/alumni-tracer/list', [AlumniTracerController::class, 'list'])->name('alumni_tracer.list');
    Route::post('/alumni-tracer/kirim-token/{id}', [AlumniTracerController::class, 'kirimToken'])->name('alumni_tracer.kirim_token');
    Route::delete('/alumni-tracer/{id}', [AlumniTracerController::class, 'destroy']);
    // export
    Route::get('/alumni-tracer/belum-isi', [AlumniTracerController::class, 'alumniBelumIsi'])->name('alumni_tracer.belum_isi');
    Route::get('/alumni-tracer/export-belum-isi', [AlumniTracerController::class, 'exportBelumIsi'])->name('alumni_tracer.export_belum_isi');
    // rekap tracer
    Route::get('/alumni-tracer/export-rekap-tracer', [AlumniTracerController::class, 'exportRekapTracer'])->name('alumni_tracer.export_rekap_tracer');





    // Alumni Routes
    Route::middleware(['check.role:alumni'])->group(function () {
        Route::get('/alumni/dashboard', [AuthController::class, 'alumniDashboard'])->name('alumni.dashboard');

        // Tracer Study Routes
        Route::prefix('tracer-study')->name('tracer-study.')->group(function () {
            Route::get('/', [TracerStudyController::class, 'index'])->name('index');

            Route::get('/data-diri', [TracerStudyController::class, 'showDataDiri'])->name('data-diri');
            Route::post('/data-diri', [TracerStudyController::class, 'storeDataDiri'])->name('store-data-diri');
            Route::get('/data-atasan', [TracerStudyController::class, 'showDataAtasan'])->name('data-atasan');
            Route::post('/data-atasan', [TracerStudyController::class, 'storeDataAtasan'])->name('store-data-atasan');
            Route::get('/kuesioner', [TracerStudyController::class, 'showKuesioner'])->name('kuesioner');
            Route::post('/kuesioner', [TracerStudyController::class, 'storeKuesioner'])->name('store-kuesioner');
            Route::get('/success', [TracerStudyController::class, 'success'])->name('success');
        });
    });
});

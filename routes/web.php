<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfesiController;
use App\Http\Controllers\KategoriProfesiController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\AlumniController;
use App\Http\Controllers\TracerStudyController;
use App\Http\Controllers\KesesuaianPekerjaanController;
use App\Http\Controllers\UserController;


// route landingpage
Route::get('/', function () {
    return view('landing_page');
});
    
// Auth Routes 
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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
            Route::delete('/destroy/{id}', [KategoriProfesiController::class, 'destroy_ajax'])->name('destroy');
        });

        // Instansi Routes
        Route::prefix('instansi')->name('instansi.')->group(function () {
            Route::get('/', [InstansiController::class, 'index'])->name('index');
            Route::get('/list', [InstansiController::class, 'list'])->name('list');
            Route::get('/create', [InstansiController::class, 'create_ajax'])->name('create');
            Route::post('/store', [InstansiController::class, 'store_ajax'])->name('store');
            Route::get('/edit/{id}', [InstansiController::class, 'edit_ajax'])->name('edit');
            Route::post('/update/{id}', [InstansiController::class, 'update_ajax'])->name('update');
            Route::delete('/destroy/{id}', [InstansiController::class, 'destroy_ajax'])->name('destroy');
        });

        // Alumni Routes (Admin)
        Route::prefix('alumni')->name('alumni.')->group(function () {
            Route::get('/', [AlumniController::class, 'index'])->name('index');
            Route::get('/list', [AlumniController::class, 'list'])->name('list');
            Route::get('/create', [AlumniController::class, 'create_ajax'])->name('create');
            Route::post('/store', [AlumniController::class, 'store_ajax'])->name('store');
            Route::get('/edit/{id}', [AlumniController::class, 'edit_ajax'])->name('edit');
            Route::post('/update/{id}', [AlumniController::class, 'update_ajax'])->name('update');
            Route::delete('/destroy/{id}', [AlumniController::class, 'destroy_ajax'])->name('destroy');
        });
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
    });

    // Alumni Routes
    Route::middleware(['check.role:alumni'])->group(function () {
        Route::get('/alumni_i/dashboard', [AuthController::class, 'alumniDashboard'])->name('alumni_i.dashboard');

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

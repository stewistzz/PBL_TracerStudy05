<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfesiController;

// Route::get('/', function () {
//     return view('welcome');
// });

// route untuk login
// Auth Routes
Route::get('/', [AuthController::class, 'login'])->name('login');
Route::post('/', [AuthController::class, 'postLogin']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Admin Routes
    Route::middleware(['check.role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->name('admin.dashboard');
        // route untuk profesi
        Route::group(['prefix' => 'profesi'], function () {
            Route::get('/', [ProfesiController::class, 'index'])->name('profesi.index');
            Route::get('/list', [ProfesiController::class, 'list'])->name('profesi.list');
            // Route::post('/', [ProfesiController::class, 'store'])->name('profesi.store');
            // Route::get('/{id}', [ProfesiController::class, 'show']);
            // Route::delete('/{id}', [ProfesiController::class, 'destroy']);

            // ajax
            Route::get('/create_ajax', [ProfesiController::class, 'create_ajax']); // menampilkan halaman form tambah user ajax
            Route::post('/ajax', [ProfesiController::class, 'store_ajax']); // menyimpan data user baru ajax
            
            // edit
            // edit dan update dengan ajax
            Route::get('/{id}/edit_ajax', [ProfesiController::class, 'edit_ajax']); // menampilkan halaman form edit user

            // update ajax
            Route::post('/{id}/update_ajax', [ProfesiController::class, 'update_ajax']);  // menyimpan perubahan data user

            // delete dengan ajax
            Route::get('/{id}/delete_ajax', [ProfesiController::class, 'confirm_ajax']);
            Route::delete('/{id}/delete_ajax', [ProfesiController::class, 'delete_ajax']);

            Route::delete('/{id}', [ProfesiController::class, 'destroy']); // menghapus data user
        });
    });

    // Alumni Routes
    Route::middleware(['check.role:alumni'])->group(function () {
        Route::get('/alumni/dashboard', [AuthController::class, 'alumniDashboard'])->name('alumni.dashboard');
    });
});

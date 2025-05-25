<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\KategoriProfesiController;
use App\Http\Controllers\InstansiController;
use App\Http\Controllers\AlumniController;

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
        
    // Route kategori_profesi
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

    Route::prefix('instansi')->name('instansi.')->group(function () {
    Route::get('/', [InstansiController::class, 'index'])->name('index');
    Route::get('/list', [InstansiController::class, 'list'])->name('list');
    Route::get('/create', [InstansiController::class, 'create_ajax'])->name('create');
    Route::post('/store', [InstansiController::class, 'store_ajax'])->name('store');
    Route::get('/edit/{id}', [InstansiController::class, 'edit_ajax'])->name('edit');
    Route::post('/update/{id}', [InstansiController::class, 'update_ajax'])->name('update'); // Gunakan POST seperti KategoriProfesi
    Route::delete('/destroy/{id}', [InstansiController::class, 'destroy_ajax'])->name('destroy');
});

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
    
    // Alumni Routes
    Route::middleware(['check.role:alumni'])->group(function () {
        Route::get('/alumni_i/dashboard', [AuthController::class, 'alumniDashboard'])->name('alumni_i.dashboard');
    });
});
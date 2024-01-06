<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    Route::prefix('dashboard')->group(function(){
        Route::get('/', function () {
            return view('admin.dashboard');
        });
        Route::get('/rooms', function () {
            return view('admin.rooms');
        });
        Route::get('/users', function () {
            return view('admin.users');
        });
        Route::get('/bookings', function () {
            return view('admin.bookings');
        });
        Route::get('/skills', function () {
            return view('admin.skills');
        });
    });

    // User Routes
    Route::get('/rooms/create', function () {
        return view('website.create');
    });
    Route::get('/myrooms', function () {
        return view('website.myrooms');
    });
    Route::get('/myrooms/{id}', function () {
        return view('website.myroomDetails');
    });
    Route::get('/notifications', function () {
        return view('website.notifications');
    });
    
    Route::get('/myrequests', function () {
        return view('website.myrequests');
    });
    Route::get('/myoffers', function () {
        return view('website.myoffers');
    });
});




Route::get('/', function () {
    return view('website.landing');
});
Route::get('/rooms', function () {
    return view('website.rooms');
});
Route::get('/room/{id}', function () {
    return view('website.roomDetails');
});




require __DIR__.'/auth.php';

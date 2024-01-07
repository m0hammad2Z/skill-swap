<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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

    // Profile Routes
    Route::prefix('profile')->group(function(){
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
    

    // User related routes
    Route::prefix('/')->group(function(){
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


    // Rooms Routes
    Route::prefix('rooms')->group(function(){
        Route::get('/', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('create', [RoomController::class, 'create'])->name('rooms.create');
        Route::get('{id}', [RoomController::class, 'show'])->name('rooms.show');
    });


    // User Rooms Routes
    Route::prefix('myrooms')->group(function(){
        Route::get('/', [RoomController::class, 'showUserRooms'])->name('rooms.userRooms');
        Route::get('{id}', [RoomController::class, 'showJoinedRoom'])->name('rooms.joinedRoom');
    });
    
});


// Landing Page
Route::get('/', function () {
    return view('website.welcome');
});


require __DIR__.'/auth.php';

<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VideoSessionController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\WalletTransactionController;
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
    

    // Rooms Routes
    Route::prefix('rooms')->group(function(){
        Route::get('/', [RoomController::class, 'index'])->name('rooms.index');
        Route::get('create', [RoomController::class, 'create'])->name('rooms.create');
        Route::get('{id}', [RoomController::class, 'show'])->name('rooms.show');
        Route::post('/create', [RoomController::class, 'store'])->name('rooms.store');
    });

    // User's Rooms Routes
    Route::prefix('myrooms')->group(function(){
        Route::get('/', [RoomController::class, 'showUserRooms'])->name('rooms.userRooms');
        Route::get('{id}', [RoomController::class, 'showJoinedRoom'])->name('rooms.joinedRoom');
        Route::delete('kick/{roomId}/{userId}', [RoomController::class, 'kickMember'])->name('rooms.kickMember');
        Route::delete('leave/{roomId}', [RoomController::class, 'leaveRoom'])->name('rooms.leaveRoom');
        Route::patch('update/{roomId}', [RoomController::class, 'updateRoom'])->name('rooms.updateRoom');
        Route::post('search', [RoomController::class, 'search'])->name('rooms.search');
    });
    
    // Booking Routes
    Route::prefix('bookings')->group(function(){
        Route::post('/store', [BookingController::class, 'store'])->name('bookings.store');
        
        //TODO: Change the method to patch
        Route::post('/accept', [BookingController::class, 'accept'])->name('bookings.accept');
        Route::post('/reject', [BookingController::class, 'reject'])->name('bookings.reject');

        Route::delete('/cancel', [BookingController::class, 'cancel'])->name('bookings.cancel');


        Route::get('/myrequests', [BookingController::class, 'myRequests'])->name('bookings.myRequests');
        Route::get('/myoffers', [BookingController::class, 'myOffers'])->name('bookings.myOffers');
    });


    // Notifications Routes
    Route::prefix('notifications')->group(function(){
        Route::get('/', [NotificationController::class, 'index'])->name('notifications.index');
        Route::post('/markAsRead/{id}', [NotificationController::class, 'markNotificationAsRead'])->name('notifications.markAsRead');
    });

     // ------ In Room Routes ------E
    // Video Session
    Route::prefix('video-session')->group(function(){
        Route::post('/store', [VideoSessionController::class, 'store'])->name('videoSession.store');
    });


    // Resources Routes (store, delete, update)
    Route::prefix('resources')->group(function(){
        Route::post('/store', [ResourceController::class, 'store'])->name('resources.store');
        Route::delete('/delete', [ResourceController::class, 'destroy'])->name('resources.destroy');
        Route::patch('/update', [ResourceController::class, 'update'])->name('resources.update');
    });

    // Wallet Routes
    Route::prefix('wallet')->group(function(){
        Route::get('/', [WalletTransactionController::class, 'index'])->name('wallet.index');
        Route::post('/deposit', [WalletTransactionController::class, 'deposit'])->name('wallet.deposit');
    });


});


// Landing Page
Route::get('/', function () {
    return view('website.welcome');
});


require __DIR__.'/auth.php';

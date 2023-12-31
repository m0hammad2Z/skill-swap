<?php

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

Route::get('/', function () {
    return view('website.landing');
});
Route::get('/rooms', function () {
    return view('website.rooms');
});
Route::get('/login', function () {
    return view('website.login');
});
Route::get('/signup', function () {
    return view('website.signup');
});
Route::get('/rooms/create', function () {
    return view('website.create');
});
Route::get('/room/{id}', function () {
    return view('website.roomDetails');
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
Route::get('/profile', function () {
    return view('website.profile');
});
Route::get('/myrequests', function () {
    return view('website.myrequests');
});
Route::get('/myoffers', function () {
    return view('website.myoffers');
});


// Admin Routes
Route::get('/dashboard', function () {
    return view('admin.dashboard');
});
Route::get('/dashboard/rooms', function () {
    return view('admin.rooms');
});
Route::get('/dashboard/users', function () {
    return view('admin.users');
});
Route::get('/dashboard/bookings', function () {
    return view('admin.bookings');
});
Route::get('/dashboard/skills', function () {
    return view('admin.skills');
});
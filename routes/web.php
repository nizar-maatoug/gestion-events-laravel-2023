<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    HomeController,
    EventSportifController,
    AdminDashboardController
    };

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

Route::get('/',HomeController::class)->name('home');

Route::prefix('organisateur')->middleware(['auth','can:organisateur-view'])->group(function (){

    Route::resource('/eventSportifs',EventSportifController::class);
});

Route::prefix('admin')->middleware(['auth','can:admin-view'])->group(function (){

    Route::get('/users',[AdminDashboardController::class,'userDashboard'])->name('admin.users');
    Route::get('/events',[AdminDashboardController::class, 'eventDashboard'])->name('admin.events');

});




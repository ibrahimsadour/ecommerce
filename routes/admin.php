<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Dzee Route is gemaakt door Ibrahim sadour 06-10-2020
// Er wordt een namespace gemaakt ook in de bestaand /RouteServiceProvider/
// Hier wordt alle admin (Routes) toegevoegd.
// wordt hier in de bestand  /RouteServiceProvider/ een apart prefix ('admin') gemaakt  


//moet de gebruiker ingelogd ben om deze route te berieken
Route::group(['namespace'=>'Admin','middleware' => 'auth:admin'], function() {
    Route::get('/', [DashboardController::class ,'index']) -> name('admin.dashboard');
});

Route::group(['namespace'=>'Admin','middleware' => 'guest:admin'], function(){
    Route::get('login' ,[LoginController::class ,'getLogin'])-> name('get.admin.login');
    Route::post('login' ,[LoginController::class ,'login']) -> name('admin.login');
});

    

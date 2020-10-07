<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LanguagesController;
use App\Http\Controllers\Admin\MainCategoriesController;
define('PAGINATION_COUNT',10); // PAGINATION_COUNT : een vast variabel  om alleen 10 items te laat zien om de pagina

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


    ############################# Begin Languages Route ###############################

    Route::group(['prefix' => 'languages'], function () {
        
        Route::get('/', [LanguagesController::class ,'index'])->name('admin.languages');
        Route::get('create', [LanguagesController::class ,'create'])->name('admin.languages.create');
        Route::post('store', [LanguagesController::class ,'store'])->name('admin.languages.store');
        Route::get('edit/{id}',[LanguagesController::class ,'edit']) -> name('admin.languages.edit');
        Route::post('update/{id}',[LanguagesController::class ,'update']) -> name('admin.languages.update');
        Route::get('delete/{id}',[LanguagesController::class ,'destroy']) -> name('admin.languages.delete');
    });
    ############################# End Languages Route ###############################



    ######################### Begin Main Categoris Routes ########################

    Route::group(['prefix' => 'main_categories'], function () {

        Route::get('/', [MainCategoriesController::class ,'index']) -> name('admin.maincategories');
        Route::get('create',[MainCategoriesController::class ,'create']) -> name('admin.maincategories.create');
        Route::post('store',[MainCategoriesController::class ,'store']) -> name('admin.maincategories.store');
        Route::get('edit/{id}',[MainCategoriesController::class ,'edit']) -> name('admin.maincategories.edit');
        Route::post('update/{id}',[MainCategoriesController::class ,'update']) -> name('admin.maincategories.update');
        Route::get('delete/{id}',[MainCategoriesController::class ,'destroy']) -> name('admin.maincategories.delete');
        Route::get('changeStatus/{id}',[MainCategoriesController::class ,'changeStatus']) -> name('admin.maincategories.status');

    });
    ######################### End  Main Categoris Routes  ########################
});

Route::group(['namespace'=>'Admin','middleware' => 'guest:admin'], function(){
    Route::get('login' ,[LoginController::class ,'getLogin'])-> name('get.admin.login');
    Route::post('login' ,[LoginController::class ,'login']) -> name('admin.login');
});



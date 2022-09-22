<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

	return view('welcome');
});

// Route::get('/tienda/{store_id}',[\App\Http\Controllers\TiendaAppManage::class,'send_settings'])->middleware('cors');


Route::get('/view',[\App\Http\Controllers\TiendaAppManage::class,'display_settings'])->middleware('auth');
Route::get('/verify',[\App\Http\Controllers\TiendaAppManage::class,'verify_user']);
Route::get('/auth', [\App\Http\Controllers\TiendaAppManage::class,'auth']);
Route::post('/settings',[\App\Http\Controllers\TiendaAppManage::class,'save_settings'])->middleware('auth')->name('settings');

Route::get('/instagram-get-auth', [\App\Http\Controllers\InstgramAuthController::class,'show']);
Route::get('/instagram-auth-response', [\App\Http\Controllers\InstgramAuthController::class,'complete']);
Route::get('/instagram-auth-success', function (){
	$feed = \Dymantic\InstagramFeed\Profile::where('username', 'apurbapodder')->first()->feed();
	return $feed;
});
Route::get('/debug',function(){
	dd('__DEBUG__');
});
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

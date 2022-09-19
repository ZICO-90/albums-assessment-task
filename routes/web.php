<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlbumPictuerController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['prefix' => 'albums' ,'as' => 'albums.'], function(){

    Route::get('/', [AlbumPictuerController::class , 'albums'])->name('index');
    Route::post('/store', [AlbumPictuerController::class , 'store'])->name('store');
    Route::get('/gallery/{id}', [AlbumPictuerController::class , 'gallery'])->name('gallery');
    Route::put('/gallery/update/{id}', [AlbumPictuerController::class , 'updateGalleryAjax'])->name('update.gallery.ajax');
    Route::put('/move/{id}', [AlbumPictuerController::class , 'moveAlbum'])->name('move');
    Route::get('/gallery/delete/{id}', [AlbumPictuerController::class , 'deletePictuer'])->name('delete.gallery');
    Route::match(['get', 'delete'] ,'/album/delete/{id}', [AlbumPictuerController::class , 'deleteAlbum'])->name('delete.album');
});

//require __DIR__.'/auth.php';

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

<?php

use App\Http\Controllers\ShopController;
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
    return redirect()->route('shop.index');
});

Route::prefix('shop')->group(function (){
    Route::get('/', [ShopController::class, 'index'])->name('shop.index');
    Route::post('/create', [ShopController::class, 'create'])->name('shop.create');
    Route::get('/read/{id}', [ShopController::class, 'read'])->name('shop.read');
    Route::post('/update', [ShopController::class, 'update'])->name('shop.update');
    Route::get('/delete/{id}', [ShopController::class, 'delete'])->name('shop.delete');
});

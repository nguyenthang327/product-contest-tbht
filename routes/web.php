<?php

use App\Http\Controllers\ComponentController;
use App\Http\Controllers\ProductConfigController;
use App\Http\Controllers\SpecificationController;
use App\Http\Controllers\ProductController;
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
    return view('layouts.master');
});

Route::prefix('component')->group(function(){
    Route::get('/', [ComponentController::class, 'index'])->name('component.index');
    Route::get('/create', [ComponentController::class, 'create'])->name('component.create');
    Route::post('/store', [ComponentController::class, 'store'])->name('component.store');
    Route::get('/edit/{id}', [ComponentController::class, 'edit'])->name('component.edit');
    Route::put('/update/{id}', [ComponentController::class, 'update'])->name('component.update');
    Route::delete('/delete/{id}', [ComponentController::class, 'destroy'])->name('component.delete');
});


Route::prefix('specification')->group(function(){
    Route::get('/', [SpecificationController::class, 'index'])->name('specification.index');
    Route::get('/create', [SpecificationController::class, 'create'])->name('specification.create');
    Route::post('/store', [SpecificationController::class, 'store'])->name('specification.store');
    Route::get('/edit/{id}', [SpecificationController::class, 'edit'])->name('specification.edit');
    Route::put('/update/{id}', [SpecificationController::class, 'update'])->name('specification.update');
    Route::delete('/delete/{id}', [SpecificationController::class, 'destroy'])->name('specification.delete');
});

Route::get('/get-by-specification-group', [SpecificationController::class, 'getBySpecificationGroup']);

Route::prefix('product')->group(function(){
    Route::get('/', [ProductController::class, 'index'])->name('product.index');
    Route::get('/detail/{id}', [ProductController::class, 'show'])->name('product.detail');
    Route::get('/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/store', [ProductController::class, 'store'])->name('product.store');
});

Route::prefix('product-config')->group(function(){
    Route::post('/store', [ProductConfigController::class, 'store'])->name('productConfig.store');
    Route::put('/update/{id}', [ProductConfigController::class, 'update'])->name('productConfig.update');
});
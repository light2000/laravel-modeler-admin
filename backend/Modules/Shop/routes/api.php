<?php

use Illuminate\Support\Facades\Route;
use Modules\Shop\Http\Controllers\Administrator\ActorController;
use Modules\Shop\Http\Controllers\Administrator\AthleteController;
use Modules\Shop\Http\Controllers\Administrator\CategoryController;
use Modules\Shop\Http\Controllers\Administrator\ProductController;
use Modules\Shop\Http\Controllers\Options\CategoryOptionsController;

Route::middleware(['auth:administrator'])->prefix('administrator/shop')->group(function () {
    Route::post('categories', [CategoryController::class, 'store'])->name('shop.category.store');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('shop.category.update');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('shop.category.edit');
    Route::get('categories', [CategoryController::class, 'index'])->name('shop.category.index');
    Route::get('categories/{category}', [CategoryController::class, 'show'])->name('shop.category.show');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('shop.category.destroy');

    Route::post('products', [ProductController::class, 'store'])->name('shop.product.store');
    Route::put('products/{product}', [ProductController::class, 'update'])->name('shop.product.update');
    Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('shop.product.edit');
    Route::get('products', [ProductController::class, 'index'])->name('shop.product.index');
    Route::get('products/{product}', [ProductController::class, 'show'])->name('shop.product.show');
    Route::delete('products/{product}', [ProductController::class, 'destroy'])->name('shop.product.destroy');

    Route::post('actors', [ActorController::class, 'store'])->name('shop.actor.store');
    Route::put('actors/{actor}', [ActorController::class, 'update'])->name('shop.actor.update');
    Route::get('actors/{actor}/edit', [ActorController::class, 'edit'])->name('shop.actor.edit');
    Route::get('actors', [ActorController::class, 'index'])->name('shop.actor.index');
    Route::get('actors/{actor}', [ActorController::class, 'show'])->name('shop.actor.show');
    Route::delete('actors/{actor}', [ActorController::class, 'destroy'])->name('shop.actor.destroy');

    Route::post('athletes', [AthleteController::class, 'store'])->name('shop.athlete.store');
    Route::put('athletes/{athlete}', [AthleteController::class, 'update'])->name('shop.athlete.update');
    Route::get('athletes/{athlete}/edit', [AthleteController::class, 'edit'])->name('shop.athlete.edit');
    Route::get('athletes', [AthleteController::class, 'index'])->name('shop.athlete.index');
    Route::get('athletes/{athlete}', [AthleteController::class, 'show'])->name('shop.athlete.show');
    Route::delete('athletes/{athlete}', [AthleteController::class, 'destroy'])->name('shop.athlete.destroy');
});

Route::middleware(['auth:administrator'])->group(function () {
    Route::get('options/shop/category', [CategoryOptionsController::class, 'index'])->name('shop.category.options');
});

<?php

use Illuminate\Support\Facades\Route;
use Modules\User\Http\Controllers\Administrator\AdministratorController;
use Modules\User\Http\Controllers\Administrator\MeController;
use Modules\User\Http\Controllers\Administrator\RoleController;
use Modules\User\Http\Controllers\Administrator\UserController;

Route::middleware(['auth:administrator'])->prefix('administrator/user')->group(function () {
    Route::post('users', [UserController::class, 'store'])->name('user.user.store');
    Route::put('users/{user}', [UserController::class, 'update'])->name('user.user.update');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('user.user.edit');
    Route::get('users', [UserController::class, 'index'])->name('user.user.index');
    Route::get('users/{user}', [UserController::class, 'show'])->name('user.user.show');
    Route::delete('users/{ids}', [UserController::class, 'destroy'])->where('ids', '[0-9,]+')->name('user.user.destroy');
    Route::post('administrators', [AdministratorController::class, 'store'])->name('user.administrator.store');
    Route::put('administrators/{administrator}', [AdministratorController::class, 'update'])->name('user.administrator.update');
    Route::get('administrators/{administrator}/edit', [AdministratorController::class, 'edit'])->name('user.administrator.edit');
    Route::get('administrators', [AdministratorController::class, 'index'])->name('user.administrator.index');
    Route::get('administrators/{administrator}', [AdministratorController::class, 'show'])->name('user.administrator.show');
    Route::delete('administrators/{ids}', [AdministratorController::class, 'destroy'])->where('ids', '[0-9,]+')->name('user.administrator.destroy');
    Route::post('roles', [RoleController::class, 'store'])->name('user.role.store');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('user.role.update');
    Route::get('roles/{role}/edit', [RoleController::class, 'edit'])->name('user.role.edit');
    Route::get('roles', [RoleController::class, 'index'])->name('user.role.index');
    Route::get('roles/{role}', [RoleController::class, 'show'])->name('user.role.show');
    Route::delete('roles/{ids}', [RoleController::class, 'destroy'])->where('ids', '[0-9,]+')->name('user.role.destroy');
    Route::put('roles/{role}/permissions', [RoleController::class, 'updatePermissions'])->name('user.role.update.permissions');
    Route::get('roles/{role}/permissions', [RoleController::class, 'editPermissions'])->name('user.role.edit.permissions');
});
Route::middleware(['auth:administrator'])->prefix('administrator/me')->group(function () {
    Route::get('/', [MeController::class, 'show'])->name('user.administrator.show.profile');
    Route::put('/profile', [MeController::class, 'updateProfile'])->name('user.administrator.update.profile');
    Route::put('/password', [MeController::class, 'updatePassword'])->name('user.administrator.update.password');
});

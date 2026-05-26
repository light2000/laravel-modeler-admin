<?php

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\AdministratorController;

Route::prefix('auth')->group(function () {
    Route::post('administrator/login', [AdministratorController::class, 'login']);
    Route::post('administrator/logout', [AdministratorController::class, 'logout']);
});

<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\PolymorphicOptionsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:administrator'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.overview');

Route::middleware(['auth:administrator'])->post('/upload', [UploadController::class, 'store'])->name("upload"); // 上传文件;

Route::middleware(['auth:administrator'])->get('/options/polymorphic', [PolymorphicOptionsController::class, 'index'])->name("polymorphic-options"); // 多态选项;


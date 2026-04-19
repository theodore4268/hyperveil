<?php

use Illuminate\Support\Facades\Route;
use Pterodactyl\Http\Controllers\Admin\Extensions\hyperveil\hyperveilExtensionController;

Route::get('/admin/extensions/hyperveil', [hyperveilExtensionController::class, 'index'])
    ->name('admin.extensions.hyperveil.index');

Route::post('/admin/extensions/hyperveil', [hyperveilExtensionController::class, 'update'])
    ->name('admin.extensions.hyperveil.update');

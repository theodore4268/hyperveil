<?php

use Illuminate\Support\Facades\Route;
use Pterodactyl\Http\Controllers\Admin\Extensions\hyperveil\hyperveilExtensionController;

Route::get('/', [hyperveilExtensionController::class, 'index']);
Route::post('/', [hyperveilExtensionController::class, 'update']);

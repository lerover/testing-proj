<?php

use App\Http\Controllers\ParticipantController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::prefix('admin')->middleware('auth')->group(function () {
    Route::resource('participants', ParticipantController::class);
});

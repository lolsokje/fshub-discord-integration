<?php

use App\Controllers\FlightCompletedController;
use Illuminate\Support\Facades\Route;

Route::post('/flights/completed', FlightCompletedController::class)->name('flights.completed');

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — e-Aspira DPM Polmed
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// API endpoint untuk FullCalendar.js
Route::get('/kegiatan/calendar', function () {
    return \App\Models\Kegiatan::with('organisasi')
        ->published()
        ->get()
        ->map(fn ($k) => $k->toCalendarEvent());
})->name('api.kegiatan.calendar');

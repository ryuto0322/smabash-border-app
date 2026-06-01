<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FighterController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/fighters',[FighterController::class, 'index'])->name('fighters.index');
Route::post('/fighters',[FighterController::class, 'store']);
Route::post('/fighters/{fighter}/win',[FighterController::class, 'win']);
Route::post('/fighters/{fighter}/lose',[FighterController::class, 'lose']);

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FighterController;
use App\Http\Controllers\FighterResultController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('/fighters',[FighterController::class, 'index'])->name('fighters.index');
Route::post('/fighters',[FighterController::class, 'store']);
Route::post('/fighters/{id}/win',[FighterController::class, 'win']);
Route::post('/fighters/{id}/lose',[FighterController::class, 'lose']);
Route::post('/match-results/update',[FighterResultController::class, 'updateResult'])->name('match-results.update');

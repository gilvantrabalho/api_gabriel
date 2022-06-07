<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\TransactionController;

Route::controller(UserController::class)->prefix('user')->group(function () {
    Route::get('getAll', 'index');
    Route::get('search/{usename}/{password}', 'search');
    Route::post('create', 'store');
    Route::post('update/{id}', 'update');
});

Route::controller(TransactionController::class)->prefix('transaction')->group(function () {
    Route::get('search-userid/{user_id}', 'show');
    Route::post('create', 'store');
    Route::get('updateStatus/{id}', 'updateStatus');
    Route::post('update/{id}', 'update');
    Route::get('get-by-id/{id}', 'getById');
//     Route::get('filter-by-description/{user_id}/{description}', 'filters');
});

Route::controller(ReleaseController::class)->prefix('release')->group(function () {
    Route::get('get-all', 'index');
    Route::post('create', 'store');
});
<?php

use App\Http\Controllers\Api\NoteApiController;
use App\Http\Controllers\Api\SheetApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/generate', [NoteApiController::class, 'generate']);
Route::delete('/clear', [NoteApiController::class, 'clear']);

Route::apiResource('/notes', NoteApiController::class);

Route::post('/sync-csv', [SheetApiController::class, 'syncCsv']);

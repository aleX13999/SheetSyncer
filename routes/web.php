<?php

use Illuminate\Support\Facades\Route;

Route::redirect('/', '/notes');

Route::get('/notes', function () {
    return view('notes.notes');
});

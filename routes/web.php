<?php

use App\Http\Controllers\Evaluator;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/evaluate', [Evaluator::class, 'evaluate'])->name('openai.evaluate');
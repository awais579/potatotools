<?php

use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ToolsController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');

    Route::get('/signup', [AdminAuthController::class, 'showSignup'])->name('signup');
    Route::post('/signup', [AdminAuthController::class, 'signup'])->name('signup.submit');
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('tools')->name('tools.')->group(function () {
    Route::redirect('/height-calculator', '/tools/height-converter', 301);
    Route::redirect('/csv-to-json-converter', '/tools/csv-to-json', 301);
    Route::redirect('/text-to-handwriting', '/tools/text-to-handwriting-converter', 301);
    Route::redirect('/text-to-handwritting-converter', '/tools/text-to-handwriting-converter', 301);

    Route::get('/height-converter', [ToolsController::class, 'heightConverter'])->name('height-converter');
    Route::get('/age-calculator', [ToolsController::class, 'ageCalculator'])->name('age-calculator');
    Route::get('/snow-day-calculator', [ToolsController::class, 'snowDayCalculator'])->name('snow-day-calculator');
    Route::get('/snow-day-calculator/methodology', [ToolsController::class, 'snowDayMethodology'])->name('snow-day-calculator.methodology');
    Route::get('/snow-day-calculator/validation', [ToolsController::class, 'snowDayValidation'])->name('snow-day-calculator.validation');
    Route::get('/csv-to-json', [ToolsController::class, 'csvToJson'])->name('csv-to-json');
    Route::get('/text-to-handwriting-converter', [ToolsController::class, 'textToHandwritingConverter'])->name('text-to-handwriting-converter');
});

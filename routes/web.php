<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

$loadJsonData = function (string $relativePath, array $fallback = []) {
    $fullPath = resource_path($relativePath);

    if (!is_file($fullPath)) {
        return $fallback;
    }

    $decoded = json_decode(file_get_contents($fullPath), true);

    return json_last_error() === JSON_ERROR_NONE && is_array($decoded) ? $decoded : $fallback;
};

$getHomePageData = function () {
    $homePageDataPath = resource_path('data/homepage-tools.json');
    $homePageData = [];

    if (is_file($homePageDataPath)) {
        $decodedHomePageData = json_decode(file_get_contents($homePageDataPath), true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decodedHomePageData)) {
            $homePageData = $decodedHomePageData;
        }
    }

    return $homePageData;
};

Route::get('/', function () use ($getHomePageData) {
    return view('pages.home', [
        'homePageData' => $getHomePageData(),
    ]);
})->name('home');

Route::redirect('/tools/height-calculator', '/tools/height-converter', 301);

Route::get('/tools/height-converter', function () use ($getHomePageData) {
    return view('tools.height-calculator', [
        'homePageData' => $getHomePageData(),
    ]);
})->name('tools.height-converter');

Route::get('/tools/age-calculator', function () {
    return view('tools.age-calculator');
})->name('tools.age-calculator');

Route::get('/tools/snow-day-calculator', function () use ($getHomePageData, $loadJsonData) {
    return view('tools.snow-day-calculator', [
        'homePageData' => $getHomePageData(),
        'snowDayMethodology' => $loadJsonData('data/snow-day-methodology.json'),
        'snowDayValidation' => $loadJsonData('data/snow-day-validation.json'),
    ]);
})->name('tools.snow-day-calculator');

Route::redirect('/tools/csv-to-json-converter', '/tools/csv-to-json', 301);

Route::get('/tools/csv-to-json', function () use ($getHomePageData) {
    return view('tools.csv-to-json-converter', [
        'homePageData' => $getHomePageData(),
    ]);
})->name('tools.csv-to-json');

Route::redirect('/tools/text-to-handwriting', '/tools/text-to-handwriting-converter', 301);
Route::redirect('/tools/text-to-handwritting-converter', '/tools/text-to-handwriting-converter', 301);

Route::get('/tools/text-to-handwriting-converter', function () use ($getHomePageData) {
    return view('tools.text-to-handwriting-converter', [
        'homePageData' => $getHomePageData(),
    ]);
})->name('tools.text-to-handwriting-converter');

Route::get('/tools/snow-day-calculator/methodology', function () use ($loadJsonData) {
    return view('tools.snow-day-calculator-methodology', [
        'methodology' => $loadJsonData('data/snow-day-methodology.json'),
    ]);
})->name('tools.snow-day-calculator.methodology');

Route::get('/tools/snow-day-calculator/validation', function () use ($loadJsonData) {
    return view('tools.snow-day-calculator-validation', [
        'validation' => $loadJsonData('data/snow-day-validation.json'),
    ]);
})->name('tools.snow-day-calculator.validation');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required', 'string'],
    ]);

    return back()
        ->withInput($request->only('email'))
        ->with('status', 'Login is not connected yet. The page is ready for design review.');
})->name('login.submit');

Route::get('/signup', function () {
    return view('auth.signup');
})->name('signup');

Route::post('/signup', function (Request $request) {
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email'],
        'password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    return back()
        ->withInput($request->only('name', 'email'))
        ->with('status', 'Signup is not connected yet. The page is ready for design review.');
})->name('signup.submit');

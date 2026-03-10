<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/tools/height-calculator', function () use ($getHomePageData) {
    return view('tools.height-calculator', [
        'homePageData' => $getHomePageData(),
    ]);
})->name('tools.height-calculator');

Route::get('/tools/age-calculator', function () {
    return view('tools.age-calculator');
})->name('tools.age-calculator');

Route::get('/tools/snow-day-calculator', function () use ($getHomePageData) {
    return view('tools.snow-day-calculator', [
        'homePageData' => $getHomePageData(),
    ]);
})->name('tools.snow-day-calculator');

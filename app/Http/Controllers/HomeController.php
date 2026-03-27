<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('pages.home', [
            'homePageData' => $this->getHomePageData(),
        ]);
    }

    private function getHomePageData(): array
    {
        $path = resource_path('data/homepage-tools.json');

        if (!is_file($path)) {
            return [];
        }

        $decoded = json_decode(file_get_contents($path), true);

        return json_last_error() === JSON_ERROR_NONE && is_array($decoded) ? $decoded : [];
    }
}

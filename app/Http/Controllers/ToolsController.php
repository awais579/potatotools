<?php

namespace App\Http\Controllers;

class ToolsController extends Controller
{
    public function heightConverter()
    {
        return view('tools.height-calculator', [
            'homePageData' => $this->getHomePageData(),
        ]);
    }

    public function ageCalculator()
    {
        return view('tools.age-calculator');
    }

    public function snowDayCalculator()
    {
        return view('tools.snow-day-calculator', [
            'homePageData' => $this->getHomePageData(),
            'snowDayMethodology' => $this->loadJsonData('data/snow-day-methodology.json'),
            'snowDayValidation' => $this->loadJsonData('data/snow-day-validation.json'),
        ]);
    }

    public function csvToJson()
    {
        return view('tools.csv-to-json-converter', [
            'homePageData' => $this->getHomePageData(),
        ]);
    }

    public function textToHandwritingConverter()
    {
        return view('tools.text-to-handwriting-converter', [
            'homePageData' => $this->getHomePageData(),
        ]);
    }

    public function snowDayMethodology()
    {
        return view('tools.snow-day-calculator-methodology', [
            'methodology' => $this->loadJsonData('data/snow-day-methodology.json'),
        ]);
    }

    public function snowDayValidation()
    {
        return view('tools.snow-day-calculator-validation', [
            'validation' => $this->loadJsonData('data/snow-day-validation.json'),
        ]);
    }

    private function getHomePageData(): array
    {
        return $this->loadJsonData('data/homepage-tools.json');
    }

    private function loadJsonData(string $relativePath, array $fallback = []): array
    {
        $path = resource_path($relativePath);

        if (!is_file($path)) {
            return $fallback;
        }

        $decoded = json_decode(file_get_contents($path), true);

        return json_last_error() === JSON_ERROR_NONE && is_array($decoded) ? $decoded : $fallback;
    }
}

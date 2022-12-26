<?php

namespace App\Http\Controllers;

use App\Http\Requests\WeatherRequest;
use App\Http\WeatherApi\OpenWeatherMapProvider;
use App\Http\WeatherApi\WeatherBitProvider;
use App\Http\Weather\AverageWeatherDataProvider;
use Illuminate\Support\Str;
use Exception;

class WeatherController extends Controller {

    public function __construct() {}


    public function index()
    {
        return view('weather');
    }

    public function submit(WeatherRequest $weatherRequest)
    {
        try {
            $country = Str::lower($weatherRequest->validated()['country']);
            $city = Str::lower($weatherRequest->validated()['city']);

            $openWeatherMapProvider = new OpenWeatherMapProvider($city, $country);
            $weatherbit = new WeatherBitProvider($city, $country);

            $averageProvider = new AverageWeatherDataProvider(
                $openWeatherMapProvider,
                $weatherbit,
            );

            $temperature = $averageProvider->getCurrentTemperature();
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('errorAPI', $e->getMessage());
        }
        return view('weather', [
            'temperature' => $temperature,
            'country' => $country,
            'city' => $city,
        ]);
    }
}

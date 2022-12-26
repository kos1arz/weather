<?php

namespace App\Http\Service;

use App\Models\Weather;
use App\Interface\WeatherDataProviderInterface;
use Carbon\Carbon;

class WeatherService
{
    public function __construct(){}

    public function saveWeatherToDB(WeatherDataProviderInterface $provider): void
    {
        Weather::create([
            'temperature' => $provider->temperature,
            'country' => $provider->country,
            'city' => $provider->city,
            'name_api' => $provider->nameApi,
        ]);
    }

    public function isLastCacheData(WeatherDataProviderInterface $provider)
    {
        $weather = Weather::where('created_at', '>=', Carbon::now()->subMinutes(5)->toDateTimeString())
            ->where('name_api', $provider->nameApi)
            ->where('city', $provider->city)
            ->where('country', $provider->country)
            ->get();
        return ($weather->count() >= 1);
    }

    public function getLastCacheData(WeatherDataProviderInterface $provider): Weather
    {
        return Weather::where('created_at', '>=', Carbon::now()->subMinutes(5)->toDateTimeString())
            ->where('name_api', $provider->nameApi)
            ->where('city', $provider->city)
            ->where('country', $provider->country)
            ->first();
    }
}

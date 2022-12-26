<?php

namespace App\Http\Weather;

use App\Interface\WeatherDataProviderInterface;

class AverageWeatherDataProvider implements WeatherDataProviderInterface
{
    protected $providers;

    public function __construct(WeatherDataProviderInterface ...$providers)
    {
        $this->providers = $providers;
    }

    public function getCurrentTemperature(): float
    {
        $sum = 0;
        $count = 0;
        foreach ($this->providers as $provider) {
            $sum += $provider->getCurrentTemperature();
            $count++;
        }
        return $sum / $count;
    }
}

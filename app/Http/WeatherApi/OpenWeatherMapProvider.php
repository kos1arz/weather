<?php

namespace App\Http\WeatherApi;

use App\Interface\WeatherDataProviderInterface;
use App\Http\Service\WeatherService;
use App\Http\Guzzle\GuzzleHttp;

class OpenWeatherMapProvider implements WeatherDataProviderInterface
{
    protected $apiKey;
    public $city;
    public $country;
    public $temperature;
    public $nameApi;
    private $weatherService;
    private $guzzleHttp;

    public function __construct(string $city, string $country)
    {
        $this->apiKey = env('OPEN_WEATHER_MAP');
        $this->city = $city;
        $this->country = $country;
        $this->nameApi = 'OPEN_WEATHER_MAP';
        $this->weatherService = new WeatherService();
        $this->guzzleHttp = new GuzzleHttp();
    }

    public function getCurrentTemperature(): ?float
    {
        if ($this->weatherService->isLastCacheData($this)) {
            return $this->weatherService->getLastCacheData($this)->temperature;
        }

        $openweathermap = $this->guzzleHttp->connection('https://api.openweathermap.org/data/2.5/weather?q='. $this->city .','. $this->country .'&units=metric&appid='.$this->apiKey);
        if(is_null($openweathermap)) {
            return null;
        }
        $this->temperature = $openweathermap->main->temp;
        $this->weatherService->saveWeatherToDB($this);
        return $this->temperature;
    }

    protected function isCacheValid(): bool
    {

        return true;
    }
}

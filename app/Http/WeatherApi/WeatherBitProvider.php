<?php

namespace App\Http\WeatherApi;

use App\Interface\WeatherDataProviderInterface;
use App\Http\Service\WeatherService;
use App\Http\Guzzle\GuzzleHttp;

class WeatherBitProvider implements WeatherDataProviderInterface
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
        $this->apiKey = env('WEATHER_BIT');
        $this->city = $city;
        $this->country = $country;
        $this->nameApi = 'WEATHER_BIT';
        $this->weatherService = new WeatherService();
        $this->guzzleHttp = new GuzzleHttp();
    }

    public function getCurrentTemperature(): float
    {
        if ($this->weatherService->isLastCacheData($this)) {
            return $this->weatherService->getLastCacheData($this)->temperature;
        }

        $test = $this->guzzleHttp->connection('https://pokeapi.co/api/v2/pokemon/ditto');
        $this->temperature = -10;
        $this->weatherService->saveWeatherToDB($this);
        // zwróć dane o temperaturze z bufora
        return $this->temperature;
    }
}

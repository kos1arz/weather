<?php

namespace App\Http\WeatherApi;

use App\Interface\WeatherDataProviderInterface;
use App\Http\Service\WeatherService;
use App\Http\Guzzle\GuzzleHttp;
use App\Http\Exception\CustomError;

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

    public function getCurrentTemperature(): ?float
    {
        if ($this->weatherService->isLastCacheData($this)) {
            return $this->weatherService->getLastCacheData($this)->temperature;
        }

        $weatherBit = $this->guzzleHttp->connection('https://api.weatherbit.io/v2.0/current?city='. $this->city .','. $this->country .'&key='. $this->apiKey .'');
        if(is_null($weatherBit)) {
            return null;
        }
        $this->temperature = $weatherBit->data[0]->temp;
        $this->weatherService->saveWeatherToDB($this);
        // zwróć dane o temperaturze z bufora
        return $this->temperature;
    }
}

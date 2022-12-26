<?php

namespace App\Interface;

interface WeatherDataProviderInterface
{
    public function getCurrentTemperature(): float;
}

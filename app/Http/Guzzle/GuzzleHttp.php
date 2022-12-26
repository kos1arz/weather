<?php

namespace App\Http\Guzzle;

use GuzzleHttp\Client;
use Exception;
use App\Http\Exception\CustomError;

class GuzzleHttp
{
    public function __construct(){}

    public function connection(string $url) {
        try {
            $client = new Client();
            $response = $client->get($url);
            return json_decode($response->getBody());
        } catch(Exception $e) {
            throw new CustomError('Błąd podczas połączenia z API', $e->getCode());
        }
    }
}

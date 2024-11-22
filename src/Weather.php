<?php

require 'vendor/autoload.php';
use GuzzleHttp\Client;
class Weather {
    const WEATHER_API_URL = 'https://api.openweathermap.org/data/2.5/weather?q=Istanbul&appid=1f2c4527291b18aaab758440a1f8e071';
    public $client;

    public $weather_data = [];
    public function __construct () {
        $this->client = new Client([
            'base_uri' => self::WEATHER_API_URL,
            'timeout'  => 2.0,
        ]);
        
        $request = $this->client->request('GET');

        $this->weather_data = json_decode($request->getBody()->getContents());
    }
    public function getWeather () {
        return $object=(object) $this->weather_data;
    }
}
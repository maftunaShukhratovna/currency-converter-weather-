<?php

require 'vendor/autoload.php';

use GuzzleHttp\Client;

class Weather {
    const BASE_URL = 'https://api.openweathermap.org/data/2.5/';
    private $client;
    private $apiKey;
    public $weather_data = [];

    public function __construct($city) {
        $this->apiKey = getenv('OPENWEATHER_API_KEY'); // API kalitni muhit o'zgaruvchisidan olish
        if (!$this->apiKey) {
            throw new Exception('API kaliti topilmadi. Iltimos, .env fayliga kalitni kiriting.');
        }

        $this->client = new Client([
            'base_uri' => self::BASE_URL,
            'timeout' => 5.0,
        ]);

        try {
            $response = $this->client->request('GET', 'weather', [
                'query' => [
                    'q' => $city,
                    'appid' => $this->apiKey,
                    'units' => 'metric', // Haroratni Selsiyda olish
                ]
            ]);

            $this->weather_data = json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            echo 'Xatolik: ' . $e->getMessage();
        }
    }

    public function getWeather() {
        return $object=(object) $this->weather_data;
    }
}

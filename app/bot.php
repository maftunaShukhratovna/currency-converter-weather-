<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

require 'src/Bot.php';
require 'src/Currency.php';
require 'src/Weather.php';

$bot = new Bot();
$currency = new Currency();
$weather = new Weather();

$update = json_decode(file_get_contents('php://input'));

if (isset($update)) {
    $message = $update->message;
    $from_id = $message->from->id;
    $chatId = $message->chat->id;
    $text = $message->text;
    $user_name = $message->from->username;

    if ($text == '/start') {
        $bot->saveUser($from_id, $user_name);
        $reply_keyboard = [
            'keyboard' => [
                [
                    ['text' => 'Ob havo'],
                    ['text' => 'Valyuta'],
                ]
            ],
            'resize_keyboard' => true, 
        ];
        $response = $bot->makeRequest('sendMessage', [
            'chat_id' => $from_id,
            'text'=>"Hello World! <a href='https://core.telegram.org/bots/api#message'> dcndsjcjsd</a>",
            'parse_mode' => 'html',
            'reply_markup' => $reply_keyboard
        ]);

        if (!$response->ok) {
            $bot->makeRequest('sendMessage', [
                'chat_id' => $from_id,
                'text'=>json_encode($response),
            ]);
        }
    }

    if ($text == 'Ob havo') {
        $weather_data = $weather->getWeather();
        $description = $weather_data->weather[0]->description;
        $temperature = $weather_data->main->temp;
        $humidity = $weather_data->main->humidity;
        $wind_speed = $weather_data->wind->speed;

        $response_text = "Ob-havo:\n";
        $response_text .= "Holati: $description\n";
        $response_text .= "Harorat: $temperature°C\n";
        $response_text .= "Namlik: $humidity%\n";
        $response_text .= "Shamol tezligi: $wind_speed m/s";

        $bot->makeRequest('sendMessage', [
            'chat_id' => $from_id,
            'text' => $response_text
        ]);
    }

    if ($text == 'Valyuta') {
        $currencies = $currency->getCurrencies();
        $currency_list = "";
        foreach ($currencies as $currency => $rate) {
            $currency_list .= $currency . ": " . $rate . "\n";
        }
        $bot->makeRequest('sendMessage', [
            'chat_id' => $from_id,
            'text' => $currency_list,
        ]);
    }

    if ($text == '/currency') {
        $currencies = $currency->getCurrencies();
        $currency_list = "";
        foreach ($currencies as $currency => $rate) {
            $currency_list .= $currency . ": " . $rate . "\n";
        }
        $bot->makeRequest('sendMessage', [
            'chat_id' => $from_id,
            'text' => $currency_list,
        ]);
    }
}
?>



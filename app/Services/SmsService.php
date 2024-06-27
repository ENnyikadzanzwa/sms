<?php
// app/Services/SmsService.php

namespace App\Services;

use Twilio\Rest\Client;

class SmsService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(env('TWILIO_SID'), env('TWILIO_TOKEN'));
    }

    public function send($phoneNumber, $message)
    {
        $this->client->messages->create(
            $phoneNumber,
            [
                'from' => env('TWILIO_FROM'),
                'body' => $message,
            ]
        );
    }
}


<?php

namespace App\Services\OneSender;

use Illuminate\Notifications\Notification;
use App\Models\User;
use GuzzleHttp\Client as GuzzleClient;

class OneSender {

    protected $client;

    protected $apiUrl;
    protected $apiKey;

    public function __construct($url, $api) {
        $this->apiUrl = $url;
        $this->apiKey = $api;
    }

    public function content($messageText) {
        $this->content = $messageText;
        return $this;
    }


    public function send($notifiable, Notification $notification) {
        
        $phone = $this->getPhoneNumber($notifiable);

        if (empty($phone)) return;

        $this->client = new GuzzleClient();

        $response = $this->client->post($this->apiUrl, [
            'json' => [
                'to' => $phone,
                'recipient_type' => 'individual',
                'type' => 'text',
                'text' => [
                    'body' => $notification->message,
                ]
            ],
            'headers' => ['Authorization' => 'Bearer ' . $this->apiKey],
        ]);

        $output = json_decode($response->getBody()->getContents(), true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $output;
        }
        
        return false;
    } 

    function getPhoneNumber($notifiable) {
        $phone = $notifiable;
        if (is_a($notifiable, User::class)) {
            $phone = $notifiable->phone;
        }
    	if (!empty($phone)) {
        	$phone = preg_replace('/[^0-9]+/', '', $phone);
            if (substr($phone, 0, 2) == '08') {
                $phone = '628' . substr($phone, 2);
            }
        }
        return $phone;
    }
}

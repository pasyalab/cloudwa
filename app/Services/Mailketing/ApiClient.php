<?php

namespace App\Services\Mailketing;

use GuzzleHttp\Client as GuzzleClient;

class ApiClient {

    protected $apiUrl;
    protected $apiKey;

    protected $senderEmail;

    public function __construct($config) {

        $this->apiUrl = $config['api_url'];
        $this->apiKey = $config['api_key'];

        $this->apiEmail = $config['api_email'];
        $this->senderEmail = $config['api_from_email'];
    }

    public function send($data) {
        $httpClient = new GuzzleClient();

        $from = $data['from_email'][0];

        $form = [
            'from_name' => $from->getName(),
            'from_email' => $this->apiEmail,
            'recipient' => $data['to'][0]['email'],
            'subject' => $data['subject'] ?? '',
            'content' => $data['text'] ?? '',
            'api_token' => $this->apiKey,
        ];

        $response = $httpClient->post($this->apiUrl, [
            'form_params' => $form,
        ]);

        $output = json_decode($response->getBody()->getContents(), true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return $output;
        }
        
        return false;
    }
}
<?php

namespace App\Services\Mailketing;

use App\Services\Mailketing\ApiClient;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\MessageConverter;
 
class MailketingTransport extends AbstractTransport
{
    /**
     * The Mailketing API client.
     *
     * @var \MailketingTransactional\ApiClient
     */
    protected $client;
 
    /**
     * Create a new Mailketing transport instance.
     *
     * @param  \MailketingTransactional\ApiClient  $client
     * @return void
     */
    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }
 
    /**
     * {@inheritDoc}
     */
    protected function doSend(SentMessage $message): void
    {
        $email = MessageConverter::toEmail($message->getOriginalMessage());
 
        $this->client->send([
            'from_email' => $email->getFrom(),
            'to' => collect($email->getTo())->map(function ($email) {
                return ['email' => $email->getAddress(), 'type' => 'to'];
            })->all(),
            'subject' => $email->getSubject(),
            'text' => $email->getTextBody(),
        ]);
    }
 
    /**
     * Get the string representation of the transport.
     *
     * @return string
     */
    public function __toString(): string
    {
        return 'mailketing';
    }
}
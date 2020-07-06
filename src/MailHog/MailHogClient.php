<?php

namespace R3H6\Typo3Testing\MailHog;

use GuzzleHttp\Client;

class MailHogClient
{
    /**
     * @var Client
     */
    protected $client;

    /**
     * MailHogClient constructor.
     * @param string $baseUri
     */
    public function __construct(string $baseUri = 'http://127.0.0.1:8025')
    {
        $this->client = new Client([
            'base_uri' => $baseUri,
            'cookies' => true,
        ]);
    }

    public function deleteAllMessages(): void
    {
        $this->client->delete('/api/v1/messages');
    }


    public function search($kind, $query)
    {
        $mails = [];
        $response = $this->client->get('/api/v2/search?' . http_build_query(['kind' => $kind, 'query' => $query]));
        $json = json_decode((string) $response->getBody(), true);
        if ($json !== false) {
            foreach ($json['items'] as $item) {
                $mails[] = new Mail($item);
            }
        }
        return $mails;
    }
}
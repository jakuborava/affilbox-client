<?php

namespace JakubOrava\AffilboxClient\Endpoints;

use JakubOrava\AffilboxClient\BaseAffilboxClient;

class Test
{
    public function __construct(protected BaseAffilboxClient $client) {}

    public function ping(): string
    {
        $response = $this->client->get('ping');

        return $response['message'] ?? '';
    }

    public function checkCredentials(): string
    {
        $response = $this->client->get('check-credentials');

        return $response['message'] ?? '';
    }
}

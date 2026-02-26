<?php

namespace JakubOrava\AffilboxClient\Endpoints;

use JakubOrava\AffilboxClient\BaseAffilboxClient;
use JakubOrava\AffilboxClient\DTO\DashboardDTO;

class Dashboard
{
    public function __construct(protected BaseAffilboxClient $client) {}

    public function get(): DashboardDTO
    {
        $response = $this->client->get('dashboard');

        return DashboardDTO::fromArray($response['data']);
    }
}

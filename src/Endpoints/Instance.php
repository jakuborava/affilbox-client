<?php

namespace JakubOrava\AffilboxClient\Endpoints;

use JakubOrava\AffilboxClient\BaseAffilboxClient;
use JakubOrava\AffilboxClient\DTO\InstanceDTO;

class Instance
{
    public function __construct(protected BaseAffilboxClient $client) {}

    public function get(): InstanceDTO
    {
        $response = $this->client->get('instance');

        return InstanceDTO::fromArray($response['data']);
    }
}

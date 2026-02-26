<?php

namespace JakubOrava\AffilboxClient\Endpoints;

use Illuminate\Support\Collection;
use JakubOrava\AffilboxClient\BaseAffilboxClient;
use JakubOrava\AffilboxClient\DTO\CampaignDTO;

class Campaigns
{
    public function __construct(protected BaseAffilboxClient $client) {}

    /**
     * @return Collection<int, CampaignDTO>
     */
    public function list(): Collection
    {
        $response = $this->client->get('campaigns/list');

        return collect($response['campaign'] ?? [])
            ->map(fn (array $item) => CampaignDTO::fromArray($item));
    }
}

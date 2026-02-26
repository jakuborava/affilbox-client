<?php

namespace JakubOrava\AffilboxClient\Endpoints;

use Illuminate\Support\Collection;
use JakubOrava\AffilboxClient\BaseAffilboxClient;
use JakubOrava\AffilboxClient\DTO\AddPartnerResponseDTO;
use JakubOrava\AffilboxClient\DTO\PartnerDTO;
use JakubOrava\AffilboxClient\Requests\AddPartnerRequest;
use JakubOrava\AffilboxClient\Requests\PartnersListRequest;

class Partners
{
    public function __construct(protected BaseAffilboxClient $client) {}

    /**
     * @return Collection<int, PartnerDTO>
     */
    public function list(?PartnersListRequest $request = null): Collection
    {
        if ($request !== null) {
            $response = $this->client->post('partner/list', $request->toArray());
        } else {
            $response = $this->client->get('partner/list');
        }

        return collect($response['partner'] ?? [])
            ->map(fn (array $item) => PartnerDTO::fromArray($item));
    }

    public function add(AddPartnerRequest $request): AddPartnerResponseDTO
    {
        $response = $this->client->post('partner/add', $request->toArray());

        return AddPartnerResponseDTO::fromArray($response);
    }
}

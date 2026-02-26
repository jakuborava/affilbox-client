<?php

namespace JakubOrava\AffilboxClient\Endpoints;

use Illuminate\Support\Collection;
use JakubOrava\AffilboxClient\BaseAffilboxClient;
use JakubOrava\AffilboxClient\DTO\ConversionDTO;
use JakubOrava\AffilboxClient\Requests\AddConversionRequest;
use JakubOrava\AffilboxClient\Requests\ChangeConversionRequest;
use JakubOrava\AffilboxClient\Requests\ConversionsListRequest;

class Conversions
{
    public function __construct(protected BaseAffilboxClient $client) {}

    /**
     * @return Collection<int, ConversionDTO>
     */
    public function list(?ConversionsListRequest $request = null): Collection
    {
        if ($request !== null) {
            $response = $this->client->post('conversions/list', $request->toArray());
        } else {
            $response = $this->client->get('conversions/list');
        }

        return collect($response['conversion'] ?? [])
            ->map(fn (array $item) => ConversionDTO::fromArray($item));
    }

    /**
     * @return array<string, mixed>
     */
    public function add(AddConversionRequest $request): array
    {
        return $this->client->post('conversions/add', $request->toArray());
    }

    /**
     * @return array<string, mixed>
     */
    public function change(ChangeConversionRequest $request): array
    {
        return $this->client->post('conversions/change', $request->toArray());
    }
}

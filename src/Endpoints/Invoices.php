<?php

namespace JakubOrava\AffilboxClient\Endpoints;

use Illuminate\Support\Collection;
use JakubOrava\AffilboxClient\BaseAffilboxClient;
use JakubOrava\AffilboxClient\DTO\InvoiceDTO;
use JakubOrava\AffilboxClient\Requests\UploadInvoiceRequest;

class Invoices
{
    public function __construct(protected BaseAffilboxClient $client) {}

    /**
     * @return Collection<int, InvoiceDTO>
     */
    public function list(): Collection
    {
        $response = $this->client->get('invoices/list');

        $invoices = $response['data']['invoices'] ?? $response['data'] ?? [];

        return collect($invoices)
            ->map(fn (array $item) => InvoiceDTO::fromArray($item));
    }

    public function billingRequest(): string
    {
        $response = $this->client->get('invoices/billing-request');

        return $response['status'] ?? '';
    }

    public function upload(UploadInvoiceRequest $request): InvoiceDTO
    {
        $response = $this->client->post('invoices/upload', $request->toArray());

        return InvoiceDTO::fromArray($response['invoice']);
    }
}

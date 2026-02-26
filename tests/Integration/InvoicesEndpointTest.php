<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use JakubOrava\AffilboxClient\AffilboxClient;
use JakubOrava\AffilboxClient\DTO\InvoiceDTO;
use JakubOrava\AffilboxClient\Requests\UploadInvoiceRequest;

beforeEach(function () {
    $this->client = new AffilboxClient('123', 'test-key');
});

it('lists invoices', function () {
    Http::fake([
        'api.affilbox.cz/invoices/list' => Http::response([
            'status' => 'ok',
            'meta' => [],
            'data' => [
                'invoices' => [
                    [
                        'id' => '109',
                        'created' => '2026-01-14 16:20:05',
                        'issueDate' => '2025-12-31 00:00:00',
                        'dueDate' => '2026-01-31 00:00:00',
                        'uploadDate' => '2026-01-15 09:27:01',
                        'supplier' => [
                            'name' => 'Orazi s.r.o.',
                            'street' => 'Plynárenská 2649',
                            'city' => 'Rožnov pod Radhoštěm',
                            'postcode' => '75661',
                            'ic' => '9941851',
                            'dic' => 'CZ09941851',
                        ],
                        'customer' => [
                            'name' => 'Jipos e-market s.r.o.',
                            'street' => 'Světecká 314',
                            'city' => 'Kostomlaty pod Milešovkou',
                            'postcode' => '41754',
                            'ic' => '9828184',
                            'dic' => 'CZ09828184',
                        ],
                        'vs' => '20250064',
                        'file' => 'https://partneri.jipos.cz/data/faktura/202600002.pdf',
                        'paid' => false,
                        'items' => [
                            [
                                'item' => 'Odměna za uskutečněné konverze (Jipos.cz)',
                                'amount' => '629.2154999999999',
                                'currency' => 'Kč',
                            ],
                        ],
                    ],
                ],
            ],
        ]),
    ]);

    $result = $this->client->invoices()->list();

    expect($result)->toHaveCount(1)
        ->and($result->first())->toBeInstanceOf(InvoiceDTO::class)
        ->and($result->first()->id)->toBe('109');

    Http::assertSent(fn ($request) => $request->method() === 'GET');
});

it('sends billing request', function () {
    Http::fake([
        'api.affilbox.cz/invoices/billing-request' => Http::response([
            'status' => 'ok',
            'meta' => [],
        ]),
    ]);

    $result = $this->client->invoices()->billingRequest();

    expect($result)->toBe('ok');
});

it('uploads an invoice', function () {
    Http::fake([
        'api.affilbox.cz/invoices/upload' => Http::response([
            'status' => 'ok',
            'meta' => [],
            'invoice' => [
                'id' => '12',
                'created' => '2023-10-08 12:18:48',
                'issueDate' => '2023-10-09 10:58:18',
                'dueDate' => '2023-10-19 0:00:00',
                'uploadDate' => '2023-10-09 11:04:26',
                'supplier' => [
                    'name' => 'AffilBox s.r.o.',
                    'street' => 'Jahnova 8',
                    'city' => 'Pardubice',
                    'postcode' => '530 02',
                    'ic' => '28777000',
                    'dic' => 'CZ28777000',
                ],
                'customer' => [
                    'name' => 'Firma s.r.o.',
                    'street' => 'Na ulici 23',
                    'city' => 'Městečko',
                    'postcode' => '51234',
                    'ic' => '123456789',
                    'dic' => 'CZ123456789',
                ],
                'vs' => '202310045',
                'file' => 'https://demo.affilbox.cz/data/faktura/202310045.pdf',
                'paid' => false,
                'items' => [
                    'item' => 'Odměna za uskutečněné konverze',
                    'amount' => 4520,
                    'currency' => 'Kč',
                ],
            ],
        ]),
    ]);

    $request = new UploadInvoiceRequest(24, Carbon::parse('2023-10-09 10:58:18'), Carbon::parse('2023-10-19 00:00:00'), 202310045, 'base64data');
    $result = $this->client->invoices()->upload($request);

    expect($result)->toBeInstanceOf(InvoiceDTO::class)
        ->and($result->id)->toBe('12');

    Http::assertSent(fn ($request) => $request->method() === 'POST');
});

<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use JakubOrava\AffilboxClient\AffilboxClient;
use JakubOrava\AffilboxClient\DTO\AddPartnerResponseDTO;
use JakubOrava\AffilboxClient\DTO\PartnerDTO;
use JakubOrava\AffilboxClient\Requests\AddPartnerRequest;
use JakubOrava\AffilboxClient\Requests\PartnersListRequest;

beforeEach(function () {
    $this->client = new AffilboxClient('123', 'test-key');
    $this->partnerResponse = [
        'status' => 'ok',
        'meta' => [],
        'partner' => [
            [
                'person' => [
                    [
                        'id' => 21,
                        'affilid' => 'ab45wcv',
                        'email' => 'partner@example.com',
                        'name' => 'Jan',
                        'surname' => 'Novák',
                        'group' => 'publisher',
                        'phone' => '+420608100100',
                        'notification' => true,
                        'recommendation' => 'ea5vb2z',
                        'register' => '2025-01-23 12:56:03',
                        'lastLogin' => '2025-03-10 8:45:21',
                        'allow' => true,
                        'consent' => true,
                    ],
                ],
                'address' => [
                    [
                        'street' => 'Národní 12',
                        'city' => 'Praha',
                        'postCode' => '10000',
                    ],
                ],
                'company' => [
                    [
                        'name' => 'Firma s.r.o.',
                        'ic' => '123456789',
                        'dic' => 'CZ123456789',
                        'dph' => false,
                    ],
                ],
            ],
        ],
    ];
});

it('lists partners with GET when no request given', function () {
    Http::fake([
        'api.affilbox.cz/partner/list' => Http::response($this->partnerResponse),
    ]);

    $result = $this->client->partners()->list();

    expect($result)->toHaveCount(1)
        ->and($result->first())->toBeInstanceOf(PartnerDTO::class)
        ->and($result->first()->person->name)->toBe('Jan');

    Http::assertSent(fn ($request) => $request->method() === 'GET');
});

it('lists partners with POST when request given', function () {
    Http::fake([
        'api.affilbox.cz/partner/list' => Http::response($this->partnerResponse),
    ]);

    $request = (new PartnersListRequest)->registerFrom(Carbon::parse('2024-01-01 00:00:00'));
    $result = $this->client->partners()->list($request);

    expect($result)->toHaveCount(1);

    Http::assertSent(fn ($request) => $request->method() === 'POST');
});

it('adds a partner', function () {
    Http::fake([
        'api.affilbox.cz/partner/add' => Http::response([
            'status' => 'ok',
            'meta' => [],
            'instance' => '2',
            'url' => 'https://demo.affilbox.cz',
            'apiKey' => 'ne374mt30zf5jna2',
            'login' => 'login',
            'password' => 'heslo',
        ]),
    ]);

    $request = (new AddPartnerRequest('partner@example.com'))
        ->name('Jan')
        ->surname('Novák');

    $result = $this->client->partners()->add($request);

    expect($result)->toBeInstanceOf(AddPartnerResponseDTO::class)
        ->and($result->instance)->toBe('2')
        ->and($result->apiKey)->toBe('ne374mt30zf5jna2');

    Http::assertSent(fn ($request) => $request->method() === 'POST');
});

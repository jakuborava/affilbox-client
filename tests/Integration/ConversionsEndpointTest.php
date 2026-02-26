<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use JakubOrava\AffilboxClient\AffilboxClient;
use JakubOrava\AffilboxClient\DTO\ConversionDTO;
use JakubOrava\AffilboxClient\Enums\ConversionState;
use JakubOrava\AffilboxClient\Requests\AddConversionRequest;
use JakubOrava\AffilboxClient\Requests\ChangeConversionRequest;
use JakubOrava\AffilboxClient\Requests\ConversionsListRequest;

beforeEach(function () {
    $this->client = new AffilboxClient('123', 'test-key');
    $this->conversionResponse = [
        'status' => 'ok',
        'meta' => [],
        'conversion' => [
            [
                'id' => '3884',
                'createDate' => '2025-03-11 10:50:50',
                'confirmDate' => '2025-03-25 21:05:56',
                'campaignName' => 'Jipos.cz',
                'campaignId' => '1',
                'value' => '9.7935',
                'sales' => '195.87',
                'currency' => 'Kč',
                'affilId' => 'ht6y7vsp',
                'partner' => 'info@orazi.cz',
                'transactionId' => '0125031251',
                'state' => 'invoiced',
                'channel' => 'zahradkaplus_cz',
                'coupon' => null,
                'comment' => null,
            ],
        ],
    ];
});

it('lists conversions with GET when no request given', function () {
    Http::fake([
        'api.affilbox.cz/conversions/list' => Http::response($this->conversionResponse),
    ]);

    $result = $this->client->conversions()->list();

    expect($result)->toHaveCount(1)
        ->and($result->first())->toBeInstanceOf(ConversionDTO::class)
        ->and($result->first()->id)->toBe('3884')
        ->and($result->first()->state)->toBe(ConversionState::Invoiced);

    Http::assertSent(fn ($request) => $request->method() === 'GET');
});

it('lists conversions with POST when request given', function () {
    Http::fake([
        'api.affilbox.cz/conversions/list' => Http::response($this->conversionResponse),
    ]);

    $request = (new ConversionsListRequest)->state(ConversionState::Authorized);
    $result = $this->client->conversions()->list($request);

    expect($result)->toHaveCount(1);

    Http::assertSent(fn ($request) => $request->method() === 'POST');
});

it('adds a conversion', function () {
    Http::fake([
        'api.affilbox.cz/conversions/add' => Http::response([
            'status' => 'ok',
            'meta' => [],
        ]),
    ]);

    $request = new AddConversionRequest(42, 'partner@example.com', Carbon::parse('2024-01-01 00:00:00'), 200);
    $result = $this->client->conversions()->add($request);

    expect($result['status'])->toBe('ok');

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && $request->url() === 'https://api.affilbox.cz/conversions/add'
    );
});

it('changes a conversion', function () {
    Http::fake([
        'api.affilbox.cz/conversions/change' => Http::response([
            'status' => 'ok',
            'meta' => [],
        ]),
    ]);

    $request = (new ChangeConversionRequest(23, ConversionState::Authorized))
        ->value(123.46);
    $result = $this->client->conversions()->change($request);

    expect($result['status'])->toBe('ok');

    Http::assertSent(fn ($request) => $request->method() === 'POST'
        && $request->url() === 'https://api.affilbox.cz/conversions/change'
    );
});

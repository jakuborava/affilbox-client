<?php

use Illuminate\Support\Facades\Http;
use JakubOrava\AffilboxClient\AffilboxClient;
use JakubOrava\AffilboxClient\DTO\DashboardDTO;

it('fetches dashboard data', function () {
    Http::fake([
        'api.affilbox.cz/dashboard' => Http::response([
            'status' => 'ok',
            'meta' => [],
            'data' => [
                'clicks' => 152,
                'conversions' => 17,
                'commission' => 1200,
                'pending' => 600,
                'payment' => 500,
                'total' => 14000,
                'uid' => '101',
            ],
        ]),
    ]);

    $client = new AffilboxClient('123', 'test-key');
    $result = $client->dashboard()->get();

    expect($result)->toBeInstanceOf(DashboardDTO::class)
        ->and($result->clicks)->toBe(152)
        ->and($result->conversions)->toBe(17);

    Http::assertSent(fn ($request) => $request->url() === 'https://api.affilbox.cz/dashboard'
        && $request->method() === 'GET'
        && $request->hasHeader('Authorization')
    );
});

<?php

use Illuminate\Support\Facades\Http;
use JakubOrava\AffilboxClient\AffilboxClient;
use JakubOrava\AffilboxClient\DTO\CampaignDTO;

it('lists campaigns', function () {
    Http::fake([
        'api.affilbox.cz/campaigns/list' => Http::response([
            'status' => 'ok',
            'meta' => [],
            'campaign' => [
                [
                    'id' => '1',
                    'name' => 'Testovací kampaň',
                    'cookieValidity' => '30',
                    'active' => true,
                    'commission' => '10',
                    'fixCommission' => '0',
                    'trackingCode' => '<script>tracking</script>',
                    'conversionCode' => '<script>conversion</script>',
                ],
            ],
        ]),
    ]);

    $client = new AffilboxClient('123', 'test-key');
    $result = $client->campaigns()->list();

    expect($result)->toHaveCount(1)
        ->and($result->first())->toBeInstanceOf(CampaignDTO::class)
        ->and($result->first()->name)->toBe('Testovací kampaň')
        ->and($result->first()->active)->toBeTrue();

    Http::assertSent(fn ($request) => $request->method() === 'GET'
        && $request->url() === 'https://api.affilbox.cz/campaigns/list'
    );
});

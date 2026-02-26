<?php

use Illuminate\Support\Facades\Http;
use JakubOrava\AffilboxClient\AffilboxClient;
use JakubOrava\AffilboxClient\DTO\InstanceDTO;

it('fetches instance data', function () {
    Http::fake([
        'api.affilbox.cz/instance' => Http::response([
            'status' => 'ok',
            'meta' => [],
            'data' => [
                'domain' => 'demo.affilbox.cz',
                'currency' => 'Kč',
                'paymentMinimum' => 500,
                'licence' => 'network',
                'locked' => false,
                'terminated' => false,
                'expire' => false,
                'conditions' => [['jazyk' => 'cz', 'text' => 'Text obchodních podmínek.']],
                'conditionsLink' => '',
                'partnerInvoiceLock' => false,
            ],
        ]),
    ]);

    $client = new AffilboxClient('123', 'test-key');
    $result = $client->instance()->get();

    expect($result)->toBeInstanceOf(InstanceDTO::class)
        ->and($result->domain)->toBe('demo.affilbox.cz')
        ->and($result->expire)->toBeFalse();
});

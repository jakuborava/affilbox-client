<?php

use Illuminate\Support\Facades\Http;
use JakubOrava\AffilboxClient\AffilboxClient;

beforeEach(function () {
    $this->client = new AffilboxClient('123', 'test-key');
});

it('pings the API', function () {
    Http::fake([
        'api.affilbox.cz/ping' => Http::response([
            'status' => 'ok',
            'meta' => [],
            'message' => 'Hi there! API version 2 here!',
        ]),
    ]);

    $result = $this->client->test()->ping();

    expect($result)->toBe('Hi there! API version 2 here!');
});

it('checks credentials', function () {
    Http::fake([
        'api.affilbox.cz/check-credentials' => Http::response([
            'status' => 'ok',
            'meta' => [],
            'message' => 'Hi there! Your credentials are valid!',
        ]),
    ]);

    $result = $this->client->test()->checkCredentials();

    expect($result)->toBe('Hi there! Your credentials are valid!');
});

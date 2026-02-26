<?php

use Illuminate\Support\Facades\Http;
use JakubOrava\AffilboxClient\BaseAffilboxClient;
use JakubOrava\AffilboxClient\Exceptions\ApiErrorException;
use JakubOrava\AffilboxClient\Exceptions\AuthenticationException;
use JakubOrava\AffilboxClient\Exceptions\UnexpectedResponseException;
use JakubOrava\AffilboxClient\Exceptions\ValidationException;

beforeEach(function () {
    $this->client = new BaseAffilboxClient('123', 'test-key');
});

it('sends GET requests with basic auth', function () {
    Http::fake([
        'api.affilbox.cz/ping' => Http::response(['status' => 'ok', 'message' => 'pong']),
    ]);

    $result = $this->client->get('ping');

    expect($result)->toBe(['status' => 'ok', 'message' => 'pong']);

    Http::assertSent(function ($request) {
        return $request->hasHeader('Authorization')
            && str_starts_with($request->header('Authorization')[0], 'Basic ')
            && $request->url() === 'https://api.affilbox.cz/ping'
            && $request->method() === 'GET';
    });
});

it('sends POST requests as form-urlencoded', function () {
    Http::fake([
        'api.affilbox.cz/partner/list' => Http::response(['status' => 'ok', 'partner' => []]),
    ]);

    $result = $this->client->post('partner/list', ['registerFrom' => '2024-01-01']);

    expect($result['status'])->toBe('ok');

    Http::assertSent(function ($request) {
        return $request->method() === 'POST'
            && $request->hasHeader('Authorization')
            && $request->url() === 'https://api.affilbox.cz/partner/list'
            && $request->body() === 'registerFrom=2024-01-01';
    });
});

it('sends GET requests with query parameters', function () {
    Http::fake([
        'api.affilbox.cz/*' => Http::response(['status' => 'ok']),
    ]);

    $this->client->get('test', ['foo' => 'bar']);

    Http::assertSent(function ($request) {
        return str_contains($request->url(), 'foo=bar');
    });
});

it('throws AuthenticationException on 401', function () {
    Http::fake([
        'api.affilbox.cz/*' => Http::response(['status' => 'error', 'message' => 'Unauthorized'], 401),
    ]);

    $this->client->get('dashboard');
})->throws(AuthenticationException::class, 'Invalid credentials.');

it('throws ValidationException on 422', function () {
    Http::fake([
        'api.affilbox.cz/*' => Http::response(['status' => 'error', 'message' => 'Invalid data'], 422),
    ]);

    $this->client->post('partner/add', []);
})->throws(ValidationException::class, 'Invalid data');

it('throws ApiErrorException on 500', function () {
    Http::fake([
        'api.affilbox.cz/*' => Http::response(['status' => 'error', 'message' => 'Server error'], 500),
    ]);

    $this->client->get('dashboard');
})->throws(ApiErrorException::class, 'Server error');

it('throws ApiErrorException when response status is error', function () {
    Http::fake([
        'api.affilbox.cz/*' => Http::response([
            'status' => 'error',
            'message' => 'Invoice can\'t be created.',
        ], 200),
    ]);

    $this->client->get('invoices/billing-request');
})->throws(ApiErrorException::class, "Invoice can't be created.");

it('throws UnexpectedResponseException on non-array response', function () {
    Http::fake([
        'api.affilbox.cz/*' => Http::response('not json', 200),
    ]);

    $this->client->get('ping');
})->throws(UnexpectedResponseException::class);

it('falls back to config values when no constructor args', function () {
    config()->set('affilbox-client.instance_number', 'config-instance');
    config()->set('affilbox-client.api_key', 'config-key');

    Http::fake([
        'api.affilbox.cz/*' => Http::response(['status' => 'ok']),
    ]);

    $client = new BaseAffilboxClient;
    $client->get('ping');

    Http::assertSent(function ($request) {
        $auth = $request->header('Authorization')[0];
        $decoded = base64_decode(str_replace('Basic ', '', $auth));

        return $decoded === 'config-instance:config-key';
    });
});

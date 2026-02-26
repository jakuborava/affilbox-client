<?php

use Carbon\Carbon;
use JakubOrava\AffilboxClient\Requests\PartnersListRequest;

it('builds partners list request with fluent API', function () {
    $request = (new PartnersListRequest)
        ->registerFrom(Carbon::parse('2024-01-01 00:00:00'))
        ->registerTo(Carbon::parse('2024-01-31 00:00:00'))
        ->lastLoginFrom(Carbon::parse('2024-01-01 00:00:00'))
        ->lastLoginTo(Carbon::parse('2024-05-30 00:00:00'));

    expect($request->toArray())->toBe([
        'registerFrom' => '2024-01-01 00:00:00',
        'registerTo' => '2024-01-31 00:00:00',
        'lastLoginFrom' => '2024-01-01 00:00:00',
        'lastLoginTo' => '2024-05-30 00:00:00',
    ]);
});

it('filters null values', function () {
    $request = (new PartnersListRequest)
        ->registerFrom(Carbon::parse('2024-01-01 00:00:00'));

    expect($request->toArray())->toBe([
        'registerFrom' => '2024-01-01 00:00:00',
    ]);
});

<?php

use Carbon\Carbon;
use JakubOrava\AffilboxClient\Requests\AddConversionRequest;

it('builds add conversion request with required and optional fields', function () {
    $request = (new AddConversionRequest(42, 'partner@example.com', Carbon::parse('2024-01-01 00:00:00'), 200))
        ->sales(3000)
        ->transactionId('2466722245')
        ->channel('top')
        ->coupon('LETOSLEVA');

    expect($request->toArray())->toBe([
        'campaignId' => 42,
        'userId' => 'partner@example.com',
        'createDate' => '2024-01-01 00:00:00',
        'value' => 200.0,
        'sales' => 3000.0,
        'transactionId' => '2466722245',
        'channel' => 'top',
        'coupon' => 'LETOSLEVA',
    ]);
});

it('builds add conversion request with only required fields', function () {
    $request = new AddConversionRequest(42, 'partner@example.com', Carbon::parse('2024-01-01 00:00:00'), 200);

    expect($request->toArray())->toBe([
        'campaignId' => 42,
        'userId' => 'partner@example.com',
        'createDate' => '2024-01-01 00:00:00',
        'value' => 200.0,
    ]);
});

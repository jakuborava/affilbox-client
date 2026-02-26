<?php

use Carbon\Carbon;
use JakubOrava\AffilboxClient\Enums\ConversionState;
use JakubOrava\AffilboxClient\Requests\ConversionsListRequest;

it('builds conversions list request', function () {
    $request = (new ConversionsListRequest)
        ->userId('partner@example.com')
        ->state(ConversionState::Authorized)
        ->dateFrom(Carbon::parse('2024-01-01 00:00:00'))
        ->dateTo(Carbon::parse('2024-02-01 00:00:00'))
        ->campaignId(42)
        ->coupon('LETOSLEVA');

    expect($request->toArray())->toBe([
        'userId' => 'partner@example.com',
        'state' => 'authorized',
        'dateFrom' => '2024-01-01 00:00:00',
        'dateTo' => '2024-02-01 00:00:00',
        'campaignId' => 42,
        'coupon' => 'LETOSLEVA',
    ]);
});

it('supports array fields', function () {
    $request = (new ConversionsListRequest)
        ->conversionsId([1, 2, 3])
        ->transactionsId(['abc', 'def']);

    $result = $request->toArray();
    expect($result['conversionsId'])->toBe([1, 2, 3])
        ->and($result['transactionsId'])->toBe(['abc', 'def']);
});

<?php

use JakubOrava\AffilboxClient\Enums\ConversionState;
use JakubOrava\AffilboxClient\Requests\ChangeConversionRequest;

it('builds change conversion request', function () {
    $request = (new ChangeConversionRequest(23, ConversionState::Authorized))
        ->value(123.46)
        ->comment('Updated');

    expect($request->toArray())->toBe([
        'conversionId' => 23,
        'state' => 'authorized',
        'value' => 123.46,
        'comment' => 'Updated',
    ]);
});

it('supports array of conversion IDs', function () {
    $request = new ChangeConversionRequest([1, 2, 3], ConversionState::Rejection);

    expect($request->toArray()['conversionId'])->toBe([1, 2, 3]);
});

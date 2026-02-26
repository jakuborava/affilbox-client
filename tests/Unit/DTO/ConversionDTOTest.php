<?php

use Carbon\Carbon;
use JakubOrava\AffilboxClient\DTO\ConversionDTO;
use JakubOrava\AffilboxClient\Enums\ConversionState;

it('creates ConversionDTO from array', function () {
    $dto = ConversionDTO::fromArray([
        'id' => '3884',
        'createDate' => '2025-03-11 10:50:50',
        'confirmDate' => '2025-03-25 21:05:56',
        'campaignName' => 'Jipos.cz',
        'campaignId' => '1',
        'value' => '9.7935',
        'sales' => '195.87',
        'currency' => 'CZK',
        'affilId' => 'sd5f432g',
        'partner' => 'partner@example.com',
        'transactionId' => '2466722245',
        'state' => 'authorized',
        'channel' => 'top',
        'coupon' => 'LETOSLEVA',
        'comment' => 'Conversion comment',
    ]);

    expect($dto->id)->toBe('3884')
        ->and($dto->createDate)->toBeInstanceOf(Carbon::class)
        ->and($dto->createDate->toDateTimeString())->toBe('2025-03-11 10:50:50')
        ->and($dto->confirmDate)->toBeInstanceOf(Carbon::class)
        ->and($dto->confirmDate->toDateTimeString())->toBe('2025-03-25 21:05:56')
        ->and($dto->campaignName)->toBe('Jipos.cz')
        ->and($dto->campaignId)->toBe('1')
        ->and($dto->value)->toBe(9.7935)
        ->and($dto->sales)->toBe(195.87)
        ->and($dto->state)->toBe(ConversionState::Authorized)
        ->and($dto->coupon)->toBe('LETOSLEVA');
});

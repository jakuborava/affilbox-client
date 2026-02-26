<?php

use JakubOrava\AffilboxClient\DTO\DashboardDTO;

it('creates DashboardDTO from array', function () {
    $dto = DashboardDTO::fromArray([
        'clicks' => 171,
        'conversions' => 18,
        'commission' => 1403.594,
        'pending' => 7168.014,
        'payment' => 0,
        'total' => 629.2155,
        'uid' => '101',
    ]);

    expect($dto->clicks)->toBe(171)
        ->and($dto->conversions)->toBe(18)
        ->and($dto->commission)->toBe(1403.594)
        ->and($dto->pending)->toBe(7168.014)
        ->and($dto->payment)->toBe(0.0)
        ->and($dto->total)->toBe(629.2155)
        ->and($dto->uid)->toBe('101');
});

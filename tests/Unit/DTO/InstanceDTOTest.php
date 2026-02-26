<?php

use Carbon\Carbon;
use JakubOrava\AffilboxClient\DTO\InstanceDTO;

it('creates InstanceDTO from array with string conditions', function () {
    $dto = InstanceDTO::fromArray([
        'domain' => 'demo.affilbox.cz',
        'currency' => 'Kč',
        'paymentMinimum' => 500,
        'licence' => 'network',
        'locked' => false,
        'terminated' => false,
        'expire' => false,
        'conditions' => 'Text obchodních podmínek.',
        'conditionsLink' => null,
        'partnerInvoiceLock' => false,
    ]);

    expect($dto->domain)->toBe('demo.affilbox.cz')
        ->and($dto->currency)->toBe('Kč')
        ->and($dto->paymentMinimum)->toBe(500.0)
        ->and($dto->licence)->toBe('network')
        ->and($dto->locked)->toBeFalse()
        ->and($dto->terminated)->toBeFalse()
        ->and($dto->expire)->toBeFalse()
        ->and($dto->conditions)->toBe('Text obchodních podmínek.')
        ->and($dto->conditionsLink)->toBeNull()
        ->and($dto->partnerInvoiceLock)->toBeFalse();
});

it('creates InstanceDTO from array with array conditions', function () {
    $dto = InstanceDTO::fromArray([
        'domain' => 'partneri.jipos.cz',
        'currency' => 'Kč',
        'paymentMinimum' => '500',
        'licence' => 'network',
        'locked' => false,
        'terminated' => false,
        'expire' => false,
        'conditions' => [
            ['jazyk' => 'cz', 'text' => '<h1>Obchodní podmínky</h1>'],
        ],
        'conditionsLink' => '',
        'partnerInvoiceLock' => false,
    ]);

    expect($dto->conditions)->toBeArray()
        ->and($dto->conditions[0]['jazyk'])->toBe('cz')
        ->and($dto->conditionsLink)->toBeNull();
});

it('handles expire as string', function () {
    $dto = InstanceDTO::fromArray([
        'domain' => 'demo.affilbox.cz',
        'currency' => 'Kč',
        'paymentMinimum' => 500,
        'licence' => 'network',
        'locked' => false,
        'terminated' => false,
        'expire' => '2025-12-31',
        'conditions' => '',
        'conditionsLink' => null,
    ]);

    expect($dto->expire)->toBeInstanceOf(Carbon::class)
        ->and($dto->expire->toDateString())->toBe('2025-12-31');
});

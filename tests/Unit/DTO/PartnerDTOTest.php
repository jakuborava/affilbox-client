<?php

use Carbon\Carbon;
use JakubOrava\AffilboxClient\DTO\PartnerDTO;

it('creates PartnerDTO from array with nested arrays', function () {
    $dto = PartnerDTO::fromArray([
        'person' => [
            [
                'id' => 21,
                'affilid' => 'ab45wcv',
                'email' => 'partner@example.com',
                'name' => 'Jan',
                'surname' => 'Novák',
                'group' => 'publisher',
                'phone' => '+420608100100',
                'notification' => true,
                'recommendation' => 'ea5vb2z',
                'register' => '2025-01-23 12:56:03',
                'lastLogin' => '2025-03-10 8:45:21',
                'allow' => true,
                'consent' => true,
            ],
        ],
        'address' => [
            [
                'street' => 'Národní 12',
                'city' => 'Praha',
                'postCode' => '10000',
            ],
        ],
        'company' => [
            [
                'name' => 'Firma s.r.o.',
                'ic' => '123456789',
                'dic' => 'CZ123456789',
                'dph' => false,
            ],
        ],
    ]);

    expect($dto->person->id)->toBe(21)
        ->and($dto->person->register)->toBeInstanceOf(Carbon::class)
        ->and($dto->person->register->toDateTimeString())->toBe('2025-01-23 12:56:03')
        ->and($dto->person->lastLogin)->toBeInstanceOf(Carbon::class)
        ->and($dto->person->lastLogin->toDateTimeString())->toBe('2025-03-10 08:45:21')
        ->and($dto->person->email)->toBe('partner@example.com')
        ->and($dto->person->name)->toBe('Jan')
        ->and($dto->person->surname)->toBe('Novák')
        ->and($dto->address->street)->toBe('Národní 12')
        ->and($dto->address->city)->toBe('Praha')
        ->and($dto->company->name)->toBe('Firma s.r.o.')
        ->and($dto->company->dph)->toBeFalse();
});

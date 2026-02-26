<?php

use Carbon\Carbon;
use JakubOrava\AffilboxClient\DTO\InvoiceDTO;

it('creates InvoiceDTO from array with items as array', function () {
    $dto = InvoiceDTO::fromArray([
        'id' => '109',
        'created' => '2026-01-14 16:20:05',
        'issueDate' => '2025-12-31 00:00:00',
        'dueDate' => '2026-01-31 00:00:00',
        'uploadDate' => '2026-01-15 09:27:01',
        'supplier' => [
            'name' => 'Orazi s.r.o.',
            'street' => 'Plynárenská 2649',
            'city' => 'Rožnov pod Radhoštěm',
            'postcode' => '75661',
            'ic' => '9941851',
            'dic' => 'CZ09941851',
        ],
        'customer' => [
            'name' => 'Jipos e-market s.r.o.',
            'street' => 'Světecká 314',
            'city' => 'Kostomlaty pod Milešovkou',
            'postcode' => '41754',
            'ic' => '9828184',
            'dic' => 'CZ09828184',
        ],
        'vs' => '20250064',
        'file' => 'https://partneri.jipos.cz/data/faktura/202600002.pdf',
        'paid' => false,
        'items' => [
            [
                'item' => 'Odměna za uskutečněné konverze (Jipos.cz)',
                'amount' => '629.2154999999999',
                'currency' => 'Kč',
            ],
        ],
    ]);

    expect($dto->id)->toBe('109')
        ->and($dto->created)->toBeInstanceOf(Carbon::class)
        ->and($dto->created->toDateTimeString())->toBe('2026-01-14 16:20:05')
        ->and($dto->issueDate->toDateTimeString())->toBe('2025-12-31 00:00:00')
        ->and($dto->dueDate->toDateTimeString())->toBe('2026-01-31 00:00:00')
        ->and($dto->uploadDate)->toBeInstanceOf(Carbon::class)
        ->and($dto->uploadDate->toDateTimeString())->toBe('2026-01-15 09:27:01')
        ->and($dto->supplier->name)->toBe('Orazi s.r.o.')
        ->and($dto->customer->name)->toBe('Jipos e-market s.r.o.')
        ->and($dto->vs)->toBe('20250064')
        ->and($dto->paid)->toBeFalse()
        ->and($dto->items)->toHaveCount(1)
        ->and($dto->items->first()->item)->toBe('Odměna za uskutečněné konverze (Jipos.cz)')
        ->and($dto->items->first()->amount)->toBe(629.2154999999999);
});

it('creates InvoiceDTO from array with items as single object', function () {
    $dto = InvoiceDTO::fromArray([
        'id' => '12',
        'created' => '2023-10-08 12:18:48',
        'issueDate' => '2023-10-09 10:58:18',
        'dueDate' => '2023-10-19 0:00:00',
        'uploadDate' => '2023-10-09 11:04:26',
        'supplier' => [
            'name' => 'AffilBox s.r.o.',
            'street' => 'Jahnova 8',
            'city' => 'Pardubice',
            'postcode' => '530 02',
            'ic' => '28777000',
            'dic' => 'CZ28777000',
        ],
        'customer' => [
            'name' => 'Firma s.r.o.',
            'street' => 'Na ulici 23',
            'city' => 'Městečko',
            'postcode' => '51234',
            'ic' => '123456789',
            'dic' => 'CZ123456789',
        ],
        'vs' => '202310045',
        'file' => 'https://demo.affilbox.cz/data/faktura/202310045.pdf',
        'paid' => false,
        'items' => [
            'item' => 'Odměna za uskutečněné konverze',
            'amount' => 4520,
            'currency' => 'Kč',
        ],
    ]);

    expect($dto->items)->toHaveCount(1)
        ->and($dto->items->first()->amount)->toBe(4520.0);
});

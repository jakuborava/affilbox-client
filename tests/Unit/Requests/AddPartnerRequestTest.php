<?php

use JakubOrava\AffilboxClient\Requests\AddPartnerRequest;

it('builds add partner request with all fields', function () {
    $request = (new AddPartnerRequest('partner@example.com'))
        ->name('Jan')
        ->surname('Novák')
        ->phone('+420608100100')
        ->street('Národní 12')
        ->city('Praha')
        ->postCode('10000')
        ->country('CZ')
        ->company('Firma s.r.o.')
        ->ic('123456789')
        ->dic('CZ123456789');

    expect($request->toArray())->toBe([
        'email' => 'partner@example.com',
        'name' => 'Jan',
        'surname' => 'Novák',
        'phone' => '+420608100100',
        'street' => 'Národní 12',
        'city' => 'Praha',
        'postCode' => '10000',
        'country' => 'CZ',
        'company' => 'Firma s.r.o.',
        'ic' => '123456789',
        'dic' => 'CZ123456789',
    ]);
});

it('builds add partner request with only email', function () {
    $request = new AddPartnerRequest('partner@example.com');

    expect($request->toArray())->toBe([
        'email' => 'partner@example.com',
    ]);
});

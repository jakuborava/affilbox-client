<?php

use JakubOrava\AffilboxClient\DTO\AddPartnerResponseDTO;

it('creates AddPartnerResponseDTO from array', function () {
    $dto = AddPartnerResponseDTO::fromArray([
        'instance' => '2',
        'url' => 'https://demo.affilbox.cz',
        'apiKey' => 'ne374mt30zf5jna2',
        'login' => 'login',
        'password' => 'heslo',
    ]);

    expect($dto->instance)->toBe('2')
        ->and($dto->url)->toBe('https://demo.affilbox.cz')
        ->and($dto->apiKey)->toBe('ne374mt30zf5jna2')
        ->and($dto->login)->toBe('login')
        ->and($dto->password)->toBe('heslo');
});

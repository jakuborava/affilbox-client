<?php

use JakubOrava\AffilboxClient\DTO\CampaignDTO;

it('creates CampaignDTO from array', function () {
    $dto = CampaignDTO::fromArray([
        'id' => '1',
        'name' => 'Testovací kampaň',
        'cookieValidity' => '30',
        'active' => true,
        'commission' => '10',
        'fixCommission' => '0',
        'trackingCode' => '<script>tracking</script>',
        'conversionCode' => '<script>conversion</script>',
    ]);

    expect($dto->id)->toBe('1')
        ->and($dto->name)->toBe('Testovací kampaň')
        ->and($dto->cookieValidity)->toBe('30')
        ->and($dto->active)->toBeTrue()
        ->and($dto->commission)->toBe('10');
});

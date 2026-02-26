<?php

namespace JakubOrava\AffilboxClient\DTO;

class CampaignDTO
{
    use ArrayHelpers;

    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $cookieValidity,
        public readonly bool $active,
        public readonly string $commission,
        public readonly string $fixCommission,
        public readonly string $trackingCode,
        public readonly string $conversionCode,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: self::getString($data, 'id'),
            name: self::getString($data, 'name'),
            cookieValidity: self::getString($data, 'cookieValidity'),
            active: self::getBool($data, 'active'),
            commission: self::getString($data, 'commission'),
            fixCommission: self::getString($data, 'fixCommission'),
            trackingCode: self::getString($data, 'trackingCode'),
            conversionCode: self::getString($data, 'conversionCode'),
        );
    }
}

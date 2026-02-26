<?php

namespace JakubOrava\AffilboxClient\DTO;

use Carbon\Carbon;
use JakubOrava\AffilboxClient\Enums\ConversionState;

class ConversionDTO
{
    use ArrayHelpers;

    public function __construct(
        public readonly string $id,
        public readonly Carbon $createDate,
        public readonly ?Carbon $confirmDate,
        public readonly string $campaignName,
        public readonly string $campaignId,
        public readonly float $value,
        public readonly float $sales,
        public readonly string $currency,
        public readonly string $affilId,
        public readonly string $partner,
        public readonly ?string $transactionId,
        public readonly ConversionState $state,
        public readonly ?string $channel,
        public readonly ?string $coupon,
        public readonly ?string $comment,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: self::getString($data, 'id'),
            createDate: self::getCarbon($data, 'createDate'),
            confirmDate: self::getCarbonOrNull($data, 'confirmDate'),
            campaignName: self::getString($data, 'campaignName'),
            campaignId: self::getString($data, 'campaignId'),
            value: self::getFloat($data, 'value'),
            sales: self::getFloat($data, 'sales'),
            currency: self::getString($data, 'currency'),
            affilId: self::getString($data, 'affilId'),
            partner: self::getString($data, 'partner'),
            transactionId: self::getStringOrNull($data, 'transactionId'),
            state: ConversionState::from(self::getString($data, 'state')),
            channel: self::getStringOrNull($data, 'channel'),
            coupon: self::getStringOrNull($data, 'coupon'),
            comment: self::getStringOrNull($data, 'comment'),
        );
    }
}

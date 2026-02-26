<?php

namespace JakubOrava\AffilboxClient\DTO;

class DashboardDTO
{
    use ArrayHelpers;

    public function __construct(
        public readonly int $clicks,
        public readonly int $conversions,
        public readonly float $commission,
        public readonly float $pending,
        public readonly float $payment,
        public readonly float $total,
        public readonly ?string $uid,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            clicks: self::getInt($data, 'clicks'),
            conversions: self::getInt($data, 'conversions'),
            commission: self::getFloat($data, 'commission'),
            pending: self::getFloat($data, 'pending'),
            payment: self::getFloat($data, 'payment'),
            total: self::getFloat($data, 'total'),
            uid: self::getStringOrNull($data, 'uid'),
        );
    }
}

<?php

namespace JakubOrava\AffilboxClient\DTO;

use Carbon\Carbon;

class InstanceDTO
{
    use ArrayHelpers;

    /**
     * @param  array<int, array<string, string>>|string|null  $conditions
     */
    public function __construct(
        public readonly string $domain,
        public readonly string $currency,
        public readonly float $paymentMinimum,
        public readonly string $licence,
        public readonly bool $locked,
        public readonly bool $terminated,
        public readonly Carbon|false $expire,
        public readonly array|string|null $conditions,
        public readonly ?string $conditionsLink,
        public readonly bool $partnerInvoiceLock,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $expire = $data['expire'] ?? false;
        $conditions = $data['conditions'] ?? null;
        $conditionsLink = $data['conditionsLink'] ?? null;

        return new self(
            domain: self::getString($data, 'domain'),
            currency: self::getString($data, 'currency'),
            paymentMinimum: self::getFloat($data, 'paymentMinimum'),
            licence: self::getString($data, 'licence'),
            locked: self::getBool($data, 'locked'),
            terminated: self::getBool($data, 'terminated'),
            expire: $expire === false ? false : Carbon::parse($expire),
            conditions: is_array($conditions) || is_string($conditions) ? $conditions : null,
            conditionsLink: is_string($conditionsLink) && $conditionsLink !== '' ? $conditionsLink : null,
            partnerInvoiceLock: self::getBool($data, 'partnerInvoiceLock'),
        );
    }
}

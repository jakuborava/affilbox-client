<?php

namespace JakubOrava\AffilboxClient\DTO;

class InvoiceItemDTO
{
    use ArrayHelpers;

    public function __construct(
        public readonly string $item,
        public readonly float $amount,
        public readonly string $currency,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            item: self::getString($data, 'item'),
            amount: self::getFloat($data, 'amount'),
            currency: self::getString($data, 'currency'),
        );
    }
}

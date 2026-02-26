<?php

namespace JakubOrava\AffilboxClient\DTO;

class SupplierDTO
{
    use ArrayHelpers;

    public function __construct(
        public readonly string $name,
        public readonly string $street,
        public readonly string $city,
        public readonly string $postcode,
        public readonly string $ic,
        public readonly string $dic,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: self::getString($data, 'name'),
            street: self::getString($data, 'street'),
            city: self::getString($data, 'city'),
            postcode: self::getString($data, 'postcode'),
            ic: self::getString($data, 'ic'),
            dic: self::getString($data, 'dic'),
        );
    }
}

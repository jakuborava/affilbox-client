<?php

namespace JakubOrava\AffilboxClient\DTO;

class AddressDTO
{
    use ArrayHelpers;

    public function __construct(
        public readonly string $street,
        public readonly string $city,
        public readonly string $postCode,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            street: self::getString($data, 'street'),
            city: self::getString($data, 'city'),
            postCode: self::getString($data, 'postCode'),
        );
    }
}

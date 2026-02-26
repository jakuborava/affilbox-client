<?php

namespace JakubOrava\AffilboxClient\DTO;

class CompanyDTO
{
    use ArrayHelpers;

    public function __construct(
        public readonly string $name,
        public readonly string $ic,
        public readonly string $dic,
        public readonly bool $dph,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            name: self::getString($data, 'name'),
            ic: self::getString($data, 'ic'),
            dic: self::getString($data, 'dic'),
            dph: self::getBool($data, 'dph'),
        );
    }
}

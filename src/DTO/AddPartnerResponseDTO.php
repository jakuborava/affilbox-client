<?php

namespace JakubOrava\AffilboxClient\DTO;

class AddPartnerResponseDTO
{
    use ArrayHelpers;

    public function __construct(
        public readonly string $instance,
        public readonly string $url,
        public readonly string $apiKey,
        public readonly string $login,
        public readonly string $password,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            instance: self::getString($data, 'instance'),
            url: self::getString($data, 'url'),
            apiKey: self::getString($data, 'apiKey'),
            login: self::getString($data, 'login'),
            password: self::getString($data, 'password'),
        );
    }
}

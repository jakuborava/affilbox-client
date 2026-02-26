<?php

namespace JakubOrava\AffilboxClient\DTO;

use Carbon\Carbon;

class PersonDTO
{
    use ArrayHelpers;

    public function __construct(
        public readonly int $id,
        public readonly string $affilid,
        public readonly string $email,
        public readonly string $name,
        public readonly string $surname,
        public readonly string $group,
        public readonly ?string $phone,
        public readonly bool $notification,
        public readonly ?string $recommendation,
        public readonly Carbon $register,
        public readonly ?Carbon $lastLogin,
        public readonly bool $allow,
        public readonly bool $consent,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            id: self::getInt($data, 'id'),
            affilid: self::getString($data, 'affilid'),
            email: self::getString($data, 'email'),
            name: self::getString($data, 'name'),
            surname: self::getString($data, 'surname'),
            group: self::getString($data, 'group'),
            phone: self::getStringOrNull($data, 'phone'),
            notification: self::getBool($data, 'notification'),
            recommendation: self::getStringOrNull($data, 'recommendation'),
            register: self::getCarbon($data, 'register'),
            lastLogin: self::getCarbonOrNull($data, 'lastLogin'),
            allow: self::getBool($data, 'allow'),
            consent: self::getBool($data, 'consent'),
        );
    }
}

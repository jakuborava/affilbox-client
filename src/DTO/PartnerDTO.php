<?php

namespace JakubOrava\AffilboxClient\DTO;

class PartnerDTO
{
    use ArrayHelpers;

    public function __construct(
        public readonly PersonDTO $person,
        public readonly AddressDTO $address,
        public readonly CompanyDTO $company,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $personData = self::getArray($data, 'person');
        $addressData = self::getArray($data, 'address');
        $companyData = self::getArray($data, 'company');

        return new self(
            person: PersonDTO::fromArray($personData[0] ?? []),
            address: AddressDTO::fromArray($addressData[0] ?? []),
            company: CompanyDTO::fromArray($companyData[0] ?? []),
        );
    }
}

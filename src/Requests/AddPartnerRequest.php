<?php

namespace JakubOrava\AffilboxClient\Requests;

class AddPartnerRequest extends BaseRequest
{
    public function __construct(string $email)
    {
        $this->addParam('email', $email);
    }

    public function name(string $name): static
    {
        return $this->addParam('name', $name);
    }

    public function surname(string $surname): static
    {
        return $this->addParam('surname', $surname);
    }

    public function phone(string $phone): static
    {
        return $this->addParam('phone', $phone);
    }

    public function street(string $street): static
    {
        return $this->addParam('street', $street);
    }

    public function city(string $city): static
    {
        return $this->addParam('city', $city);
    }

    public function postCode(string $postCode): static
    {
        return $this->addParam('postCode', $postCode);
    }

    public function country(string $country): static
    {
        return $this->addParam('country', $country);
    }

    public function company(string $company): static
    {
        return $this->addParam('company', $company);
    }

    public function ic(string $ic): static
    {
        return $this->addParam('ic', $ic);
    }

    public function dic(string $dic): static
    {
        return $this->addParam('dic', $dic);
    }
}

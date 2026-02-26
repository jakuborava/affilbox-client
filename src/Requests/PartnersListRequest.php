<?php

namespace JakubOrava\AffilboxClient\Requests;

use Carbon\CarbonInterface;

class PartnersListRequest extends BaseRequest
{
    public function registerFrom(CarbonInterface $date): static
    {
        return $this->addParam('registerFrom', $date->format('Y-m-d H:i:s'));
    }

    public function registerTo(CarbonInterface $date): static
    {
        return $this->addParam('registerTo', $date->format('Y-m-d H:i:s'));
    }

    public function lastLoginFrom(CarbonInterface $date): static
    {
        return $this->addParam('lastLoginFrom', $date->format('Y-m-d H:i:s'));
    }

    public function lastLoginTo(CarbonInterface $date): static
    {
        return $this->addParam('lastLoginTo', $date->format('Y-m-d H:i:s'));
    }
}

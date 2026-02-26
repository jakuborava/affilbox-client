<?php

namespace JakubOrava\AffilboxClient\Requests;

use Carbon\CarbonInterface;
use JakubOrava\AffilboxClient\Enums\ConversionState;

class ConversionsListRequest extends BaseRequest
{
    public function userId(string $userId): static
    {
        return $this->addParam('userId', $userId);
    }

    /**
     * @param  array<int>  $ids
     */
    public function conversionsId(array $ids): static
    {
        return $this->addParam('conversionsId', $ids);
    }

    public function state(ConversionState $state): static
    {
        return $this->addParam('state', $state->value);
    }

    public function dateFrom(CarbonInterface $date): static
    {
        return $this->addParam('dateFrom', $date->format('Y-m-d H:i:s'));
    }

    public function dateTo(CarbonInterface $date): static
    {
        return $this->addParam('dateTo', $date->format('Y-m-d H:i:s'));
    }

    public function conversionFromId(int $id): static
    {
        return $this->addParam('conversionFromId', $id);
    }

    public function campaignId(int $id): static
    {
        return $this->addParam('campaignId', $id);
    }

    /**
     * @param  array<string>  $ids
     */
    public function transactionsId(array $ids): static
    {
        return $this->addParam('transactionsId', $ids);
    }

    public function coupon(string $coupon): static
    {
        return $this->addParam('coupon', $coupon);
    }
}

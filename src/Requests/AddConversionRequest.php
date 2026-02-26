<?php

namespace JakubOrava\AffilboxClient\Requests;

use Carbon\CarbonInterface;

class AddConversionRequest extends BaseRequest
{
    public function __construct(int $campaignId, string $userId, CarbonInterface $createDate, float $value)
    {
        $this->addParam('campaignId', $campaignId);
        $this->addParam('userId', $userId);
        $this->addParam('createDate', $createDate->format('Y-m-d H:i:s'));
        $this->addParam('value', $value);
    }

    public function sales(float $sales): static
    {
        return $this->addParam('sales', $sales);
    }

    public function transactionId(string $transactionId): static
    {
        return $this->addParam('transactionId', $transactionId);
    }

    public function channel(string $channel): static
    {
        return $this->addParam('channel', $channel);
    }

    public function coupon(string $coupon): static
    {
        return $this->addParam('coupon', $coupon);
    }
}

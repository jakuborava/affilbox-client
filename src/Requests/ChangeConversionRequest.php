<?php

namespace JakubOrava\AffilboxClient\Requests;

use JakubOrava\AffilboxClient\Enums\ConversionState;

class ChangeConversionRequest extends BaseRequest
{
    public function __construct(int|array $conversionId, ConversionState $state)
    {
        $this->addParam('conversionId', $conversionId);
        $this->addParam('state', $state->value);
    }

    public function value(float $value): static
    {
        return $this->addParam('value', $value);
    }

    public function sales(float $sales): static
    {
        return $this->addParam('sales', $sales);
    }

    public function currency(string $currency): static
    {
        return $this->addParam('currency', $currency);
    }

    public function comment(string $comment): static
    {
        return $this->addParam('comment', $comment);
    }
}

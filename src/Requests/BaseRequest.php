<?php

namespace JakubOrava\AffilboxClient\Requests;

abstract class BaseRequest
{
    /** @var array<string, mixed> */
    protected array $params = [];

    protected function addParam(string $key, mixed $value): static
    {
        $this->params[$key] = $value;

        return $this;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return array_filter($this->params, fn (mixed $value) => $value !== null);
    }
}

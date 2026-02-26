<?php

namespace JakubOrava\AffilboxClient;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use JakubOrava\AffilboxClient\Exceptions\ApiErrorException;
use JakubOrava\AffilboxClient\Exceptions\AuthenticationException;
use JakubOrava\AffilboxClient\Exceptions\UnexpectedResponseException;
use JakubOrava\AffilboxClient\Exceptions\ValidationException;

class BaseAffilboxClient
{
    private const BASE_URL = 'https://api.affilbox.cz';

    protected string $instanceNumber;

    protected string $apiKey;

    public function __construct(?string $instanceNumber = null, ?string $apiKey = null)
    {
        $this->instanceNumber = $instanceNumber ?? (string) config('affilbox-client.instance_number');
        $this->apiKey = $apiKey ?? (string) config('affilbox-client.api_key');
    }

    /**
     * @param  array<string, mixed>  $queryParams
     * @return array<string, mixed>
     *
     * @throws AuthenticationException
     * @throws ValidationException
     * @throws ApiErrorException
     * @throws UnexpectedResponseException
     */
    public function get(string $path, array $queryParams = []): array
    {
        $response = $this->prepareClient()->get(self::BASE_URL.'/'.$path, $queryParams);

        return $this->handleResponse($response);
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     *
     * @throws AuthenticationException
     * @throws ValidationException
     * @throws ApiErrorException
     * @throws UnexpectedResponseException
     */
    public function post(string $path, array $data = []): array
    {
        $response = $this->prepareClient()->asForm()->post(self::BASE_URL.'/'.$path, $data);

        return $this->handleResponse($response);
    }

    protected function prepareClient(): PendingRequest
    {
        return Http::withBasicAuth($this->instanceNumber, $this->apiKey)
            ->acceptJson()
            ->timeout(30);
    }

    /**
     * @return array<string, mixed>
     *
     * @throws AuthenticationException
     * @throws ValidationException
     * @throws ApiErrorException
     * @throws UnexpectedResponseException
     */
    protected function handleResponse(Response $response): array
    {
        if ($response->status() === 401) {
            throw new AuthenticationException('Invalid credentials.');
        }

        if ($response->status() === 422) {
            throw new ValidationException($response->json('message', 'Validation error.'), 422);
        }

        if ($response->failed()) {
            $message = $response->json('message', 'API request failed.');
            throw new ApiErrorException($message, $response->status());
        }

        /** @var array<string, mixed>|null $body */
        $body = $response->json();

        if (! is_array($body)) {
            throw new UnexpectedResponseException('Unexpected response format.');
        }

        if (($body['status'] ?? null) === 'error') {
            throw new ApiErrorException($body['message'] ?? 'Unknown API error.', $response->status());
        }

        return $body;
    }
}

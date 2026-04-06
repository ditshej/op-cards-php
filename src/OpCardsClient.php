<?php

namespace Ditshej\OpCards;

use Ditshej\OpCards\Exceptions\ApiException;
use Ditshej\OpCards\Exceptions\AuthenticationException;
use Ditshej\OpCards\Exceptions\NotFoundException;
use Ditshej\OpCards\Exceptions\RateLimitException;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\BadResponseException;

class OpCardsClient
{
    private ClientInterface $http;

    public function __construct(
        private readonly string $token,
        ?ClientInterface $http = null,
    ) {
        $this->http = $http ?? new Client([
            'base_uri' => 'https://op-cards.ditshej.ch/api/',
        ]);
    }

    public function request(string $method, string $path, array $options = []): array
    {
        try {
            $options['headers']['Authorization'] = "Bearer {$this->token}";

            $response = $this->http->request($method, $path, $options);

            return json_decode((string) $response->getBody(), true, 512, JSON_THROW_ON_ERROR);
        } catch (BadResponseException $e) {
            $status = $e->getResponse()->getStatusCode();

            throw match ($status) {
                401 => new AuthenticationException($e->getMessage(), $status, $e),
                404 => new NotFoundException($e->getMessage(), $status, $e),
                429 => new RateLimitException($e->getMessage(), $status, $e),
                default => new ApiException($e->getMessage(), $status, $e),
            };
        }
    }
}

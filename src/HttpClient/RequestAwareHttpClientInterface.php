<?php

declare(strict_types=1);

namespace Setono\HttpClientBundle\HttpClient;

use Setono\HttpClientBundle\HttpClient\Request\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

interface RequestAwareHttpClientInterface extends HttpClientInterface
{
    /**
     * @return Request[]
     */
    public function getRequests(): array;

    /**
     * Returns the request associated with the given response. Returns null if no request matches
     */
    public function getRequestFromResponse(ResponseInterface $response): ?Request;

    public function getLastRequest(): ?Request;
}

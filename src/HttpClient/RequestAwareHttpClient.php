<?php

declare(strict_types=1);

namespace Setono\HttpClientBundle\HttpClient;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Setono\HttpClientBundle\HttpClient\Request\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;
use Symfony\Contracts\Service\ResetInterface;

final class RequestAwareHttpClient implements RequestAwareHttpClientInterface, ResetInterface, LoggerAwareInterface
{
    private HttpClientInterface $decorated;

    /** @var array<string, Request> */
    private array $requests = [];

    public function __construct(HttpClientInterface $client)
    {
        $this->decorated = $client;
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $response = $this->decorated->request($method, $url, $options);

        $this->requests[spl_object_hash($response)] = new Request($method, $url, $options);

        return $response;
    }

    public function stream($responses, float $timeout = null): ResponseStreamInterface
    {
        return $this->decorated->stream($responses, $timeout);
    }

    public function getRequests(): array
    {
        return $this->requests;
    }

    public function getRequestFromResponse(ResponseInterface $response): ?Request
    {
        return $this->requests[spl_object_hash($response)] ?? null;
    }

    public function getLastRequest(): ?Request
    {
        $lastRequest = end($this->requests);
        if (false === $lastRequest) {
            return null;
        }

        return $lastRequest;
    }

    public function reset(): void
    {
        if ($this->decorated instanceof ResetInterface) {
            $this->decorated->reset();
        }

        $this->requests = [];
    }

    public function setLogger(LoggerInterface $logger): void
    {
        if ($this->decorated instanceof LoggerAwareInterface) {
            $this->decorated->setLogger($logger);
        }
    }
}

<?php

declare(strict_types=1);

namespace Setono\HttpClientBundle\HttpClient\Request;

final class Request
{
    private string $method;

    private string $url;

    private array $options;

    public function __construct(string $method, string $url, array $options)
    {
        $this->method = $method;
        $this->url = $url;
        $this->options = $options;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}

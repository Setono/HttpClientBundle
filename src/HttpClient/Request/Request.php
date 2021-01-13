<?php

declare(strict_types=1);

namespace Setono\HttpClientBundle\HttpClient\Request;

use function Safe\json_encode;
use function Safe\sprintf;

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

    public function asString(): string
    {
        /** @var mixed $body */
        $body = $this->getOptions()['body'] ?? '';
        if (!is_string($body) && !is_array($body)) {
            $body = sprintf('Body is of type %s and could not be stringified...', gettype($body));
        }

        if (is_array($body)) {
            $body = print_r($body, true);
        }

        if (isset($this->getOptions()['json'])) {
            $body = json_encode($this->getOptions()['json'], \JSON_HEX_TAG | \JSON_HEX_APOS | \JSON_HEX_AMP | \JSON_HEX_QUOT | \JSON_PRESERVE_ZERO_FRACTION);
        }

        return sprintf('%s %s %s', $this->getMethod(), $this->getUrl(), $body);
    }

    public function __toString(): string
    {
        return $this->asString();
    }
}

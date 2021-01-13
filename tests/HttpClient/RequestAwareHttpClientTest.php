<?php

declare(strict_types=1);

namespace Setono\HttpClientBundle\Tests\HttpClient;

use PHPUnit\Framework\TestCase;
use Setono\HttpClientBundle\HttpClient\RequestAwareHttpClient;
use Symfony\Component\HttpClient\HttpClient;

final class RequestAwareHttpClientTest extends TestCase
{
    /**
     * @test
     */
    public function it_saves_requests(): void
    {
        $httpClient = new RequestAwareHttpClient(HttpClient::create());
        $response = $httpClient->request('GET', 'https://httpbin.org/get');

        $request = $httpClient->getRequestFromResponse($response);

        self::assertNotNull($request);
        self::assertSame('GET', $request->getMethod());
        self::assertSame('https://httpbin.org/get', $request->getUrl());
        self::assertSame([], $request->getOptions());
    }
}

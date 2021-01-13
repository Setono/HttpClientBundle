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
        $options = ['json' => ['name' => 'John Doe']];

        $httpClient = new RequestAwareHttpClient(HttpClient::create());
        $response = $httpClient->request('POST', 'https://httpbin.org/post', $options);

        $request = $httpClient->getRequestFromResponse($response);

        self::assertNotNull($request);
        self::assertSame('POST', $request->getMethod());
        self::assertSame('https://httpbin.org/post', $request->getUrl());
        self::assertSame($options, $request->getOptions());
        self::assertSame('POST https://httpbin.org/post {"name":"John Doe"}', $request->asString());
    }
}

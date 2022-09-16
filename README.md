# Symfony HTTP Client Bundle

[![Latest Version][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]

**USE https://github.com/Setono/request-aware-http-client INSTEAD**

This bundle will decorate Symfonys HTTP client and make it possible to retrieve full requests for debugging etc.

## Installation

### Step 1: Download

```bash
$ composer require setono/http-client-bundle
```

### Step 2: Enable the bundle

If you use [Symfony Flex](https://flex.symfony.com/) it will be enabled automatically. Else you need to add it to the `config/bundles.php`:

```php
<?php
// config/bundles.php

return [
    // ...

    Setono\HttpClientBundle\SetonoHttpClientBundle::class => ['all' => true],

    // ...
];
```

## Usage

Right now you manually decorate your HTTP client. In the future this will be done automatically for you.

```php
<?php
use Setono\HttpClientBundle\HttpClient\RequestAwareHttpClient;
use Setono\HttpClientBundle\HttpClient\RequestAwareHttpClientInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class YourService
{
    private RequestAwareHttpClientInterface $httpClient;
    
    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = new RequestAwareHttpClient($httpClient);
    }
    
    public function doSomething(): void
    {
        $response = $this->httpClient->request('POST', 'https://httpbin.org/post', [
            'json' => ['name' => 'John Doe']
        ]);

        $request = $this->httpClient->getRequestFromResponse($response);

        echo $request->asString();
        
        // Outputs:
        // POST https://httpbin.org/post {"name":"John Doe"}
    }
}
```

[ico-version]: https://poser.pugx.org/setono/http-client-bundle/v/stable
[ico-license]: https://poser.pugx.org/setono/http-client-bundle/license
[ico-github-actions]: https://github.com/Setono/HttpClientBundle/workflows/build/badge.svg

[link-packagist]: https://packagist.org/packages/setono/http-client-bundle
[link-github-actions]: https://github.com/Setono/HttpClientBundle/actions

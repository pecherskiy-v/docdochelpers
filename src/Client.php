<?php

namespace Pecherskiy\DocDoc;

use Buzz\Browser;
use Buzz\Client\FileGetContents;
use Buzz\Middleware\BasicAuthMiddleware;
use Pecherskiy\DocDoc\Helpers\Headers;
use Pecherskiy\DocDoc\Interfaces\ClientInterface;
use Nyholm\Psr7\Factory\Psr17Factory;
use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;
use Psr\Http\Message\ResponseInterface;

use function json_decode;

/**
 * Class Client
 * @package Pecherskiy\DocDoc
 */
class Client implements ClientInterface
{
    /**
     * @var Browser
     */
    protected $browser;

    /**
     * @var string
     */
    protected $apiUrl = '';

    /**
     * @var string
     */
    protected $method;

    /**
     * @var bool
     */
    protected $assoc;

    /**
     * Client constructor.
     *
     * @param string $username
     * @param string $password
     * @param string $serverType
     */
    public function __construct(
        string $username,
        string $password,
        string $serverType = 'production'
    ) {
        $client = new FileGetContents();
        $this->browser = new Browser($client, new Psr17Factory());
        $auth = new BasicAuthMiddleware($username, $password);
        $this->browser->addMiddleware($auth);
        $this->apiUrl = Constants::getServerUrl($serverType);
    }

    /**
     * @param string $method
     * @return Client
     */
    public function setMethod(string $method): ClientInterface
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @param Headers|null $headers
     * @return ResponseInterface
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function get(Headers $headers = null): ResponseInterface
    {
        $headersArr = $headers ? $headers->toArray() : [];

        return $this->handleResponse($this->browser->get($this->getRequestUrl(), $headersArr));
    }

    /**
     * @param Headers|null $headers
     * @param string $body
     * @return ResponseInterface
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function post(Headers $headers = null, string $body = ''): ResponseInterface
    {
        $headersArr = $headers ? $headers->toArray() : [];

        return $this->handleResponse($this->browser->post($this->getRequestUrl(), $headersArr, $body));
    }

    /**
     * @return object
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function getJson()
    {
        return json_decode($this->get()->getBody()->getContents(), false);
    }

    /**
     * @return string
     * @throws MethodIsNotSet
     */
    protected function getRequestUrl(): string
    {
        if (null === $this->method) {
            throw new MethodIsNotSet('It is necessary to establish a method for accessing api');
        }

        return $this->apiUrl . $this->method;
    }

    /**
     * @param ResponseInterface $response
     * @return ResponseInterface
     * @throws Unauthorized
     */
    protected function handleResponse(ResponseInterface $response): ResponseInterface
    {
        switch ($response->getStatusCode()) {
            case 401:
                throw new Unauthorized($response->getReasonPhrase());
            case 200:
            default:
                return $response;
        }
    }
}

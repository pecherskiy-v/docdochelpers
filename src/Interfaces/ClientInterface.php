<?php

namespace Pecherskiy\DocDoc\Interfaces;

use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;
use Pecherskiy\DocDoc\Helpers\Headers;
use Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    /**
     * @param string $method
     * @return ClientInterface
     */
    public function setMethod(string $method): ClientInterface;

    /**
     * @param Headers|null $headers
     * @throws MethodIsNotSet
     * @throws Unauthorized
     * @return ResponseInterface
     */
    public function get(Headers $headers = null): ResponseInterface;

    /**
     * @param Headers|null $headers
     * @param string|null $body
     * @throws MethodIsNotSet
     * @throws Unauthorized
     * @return ResponseInterface
     */
    public function post(Headers $headers = null, ?string $body = ''): ResponseInterface;

    /**
     * @return array|object
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function getJson();
}

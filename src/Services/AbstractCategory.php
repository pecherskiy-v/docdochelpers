<?php

namespace Pecherskiy\DocDoc\Services;

use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Interfaces\ClientInterface;

/**
 * Class AbstractCategory
 * @package Pecherskiy\DocDoc\Category
 */
abstract class AbstractCategory
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * AbstractCategory constructor.
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $query
     * @param string $key
     * @return array|object
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    protected function get(string $query, string $key)
    {
        $this->client->setMethod($query);
        $response = $this->client->getJson();
        if (\is_array($response)) {
            if (isset($response[$key])) {
                return $response;
            }
        } else {
            if (isset($response->$key)) {
                return $response;
            }
        }
        throw new ResponseError($response['message'] ?? 'Response is error');
    }

    /**
     * @param string $query
     * @param string $key
     * @return array|object
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    protected function getOnly(string $query, string $key)
    {
        $get = $this->get($query, $key);
        if (\is_array($get)) {
            return $get[$key];
        } else {
            return $get->$key;
        }
    }

    /**
     * @param string $query
     * @param string $key
     * @return array
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    protected function getFirst(string $query, string $key): array
    {
        $response = $this->get($query, $key);
        if (isset($response[$key][0])) {
            return $response[$key][0];
        }
        throw new ResponseError($response['message'] ?? 'Response is error');
    }
}

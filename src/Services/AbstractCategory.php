<?php

namespace Pecherskiy\DocDoc\Services;

use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;
use Pecherskiy\DocDoc\Interfaces\ClientInterface;

use function is_array;

/**
 * Class AbstractCategory
 * @package Pecherskiy\DocDoc\Category
 */
abstract class  AbstractCategory
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
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    protected function get(string $query, string $key)
    {
        $this->client->setMethod($query);
        $response = $this->client->getJson();
        if (is_array($response)) {
            if (isset($response[$key])) {
                return $response;
            }
        } elseif (isset($response->$key)) {
            return $response;
        }
        throw new ResponseError($response['message'] ?? 'Response is error');
    }

    /**
     * @param string $query
     * @param string $key
     * @return array|object
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    protected function getOnly(string $query, string $key)
    {
        $get = $this->get($query, $key);
        if (is_array($get)) {
            return $get[$key];
        }

        return $get->$key;
    }

    /**
     * @param string $query
     * @param string $key
     * @return array
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
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

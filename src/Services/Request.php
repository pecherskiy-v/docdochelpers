<?php

namespace Pecherskiy\DocDoc\Services;

use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Helpers\Headers;
use Pecherskiy\DocDoc\Helpers\Builders\RequestQueryBuilder;

/**
 * Class Request
 * @package Pecherskiy\DocDoc\Services
 */
class Request extends AbstractCategory
{
    /**
     * @param RequestQueryBuilder $queryBuilder
     * @return array ["status" => "success|error", "message" => "*"]
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\RequiredFieldIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    public function send(RequestQueryBuilder $queryBuilder): array
    {
        $this->client->setMethod('request');
        $response = \json_decode($this->client->post(
            new Headers(['Content-Type' => 'application/json']),
            \json_encode($queryBuilder->getQuery())
        )->getBody()->getContents(), true);
        if (isset($response['Response'])) {
            return $response['Response'];
        }
        throw new ResponseError($response['message'] ?? 'Response is error');
    }
}

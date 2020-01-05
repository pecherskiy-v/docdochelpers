<?php

namespace Pecherskiy\DocDoc\Services;

use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\RequiredFieldIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;
use Pecherskiy\DocDoc\Helpers\Headers;
use Pecherskiy\DocDoc\Helpers\Builders\RequestQueryBuilder;

use function json_decode;
use function json_encode;

/**
 * Class Request
 *
 * @package Pecherskiy\DocDoc\Services
 */
class Request extends AbstractCategory
{
    /**
     * @param RequestQueryBuilder $queryBuilder
     *
     * @return object
     * @throws MethodIsNotSet
     * @throws RequiredFieldIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     * @example {
     *              "Response": {
     *                  "status": "success",
     *                  "message": "Заявка принята",
     *                  "id": 5762185
     *              }
     *          }
     */
    public function send(RequestQueryBuilder $queryBuilder): object
    {
        $this->client->setMethod('/request');
        $response = json_decode(
            $this->client->post(
                new Headers(['Content-Type' => 'application/json']),
                json_encode($queryBuilder->getQuery())
            )->getBody()->getContents(),
            false
        );
        if (isset($response->Response)) {
            return $response->Response;
        }
        throw new ResponseError($response->message ?? 'Response is error');
    }
}

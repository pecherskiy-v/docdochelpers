<?php

namespace Pecherskiy\DocDoc\Tests\Services;

use Exception;
use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;
use Pecherskiy\DocDoc\Helpers\Builders\RequestQueryBuilder;
use Pecherskiy\DocDoc\Services\Request;

use function random_int;

class RequestTest extends AbstractCategoryTest
{
    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     * @throws Exception
     */
    public function testSend(): void
    {
        $request = new Request($this->client);
        $response = $request->send(
            (new RequestQueryBuilder())
            ->setCity(1)
            ->setName('text')
            ->setPhone('7' . random_int(1000000000, 9999999999))
        );
        static::assertObjectHasAttribute('status', $response);
        static::assertEquals('success', $response->status);
    }
}

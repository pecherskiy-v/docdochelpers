<?php

namespace Pecherskiy\DocDoc\Tests\Services;

use Pecherskiy\DocDoc\Helpers\Builders\RequestQueryBuilder;
use Pecherskiy\DocDoc\Services\Request;

class RequestTest extends AbstractCategoryTest
{
    /**
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\RequiredFieldIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     * @throws \Exception
     */
    public function testSend(): void
    {
        $request = new Request($this->client);
        $response = $request->send(
            (new RequestQueryBuilder)
            ->setCity(1)
            ->setName('text')
            ->setPhone('7' . \random_int(1000000000, 9999999999))
        );
        $this->assertArrayHasKey('status', $response);
        $this->assertEquals('success', $response['status']);
    }
}

<?php

namespace Pecherskiy\DocDoc\Tests\Services;

use Pecherskiy\DocDoc\Client;
use Pecherskiy\DocDoc\Constants;
use PHPUnit\Framework\TestCase;

use function getenv;

abstract class AbstractCategoryTest extends TestCase
{
    /**
     * @var Client
     */
    protected $client;

    public function setUp(): void
    {
        $this->client = new Client(
            getenv('DOCDOC_LOGIN'),
            getenv('DOCDOC_PASSWORD'),
            Constants::TEST_SERVER
        );
    }
}

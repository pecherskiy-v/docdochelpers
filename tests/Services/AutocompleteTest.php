<?php

namespace Pecherskiy\DocDoc\Tests\Services;

use Pecherskiy\DocDoc\Services\ServiceAutocomplete;

class AutocompleteTest extends AbstractCategoryTest
{
    /**
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    public function testAutocomplete(): void
    {
        $autocomplete = new ServiceAutocomplete($this->client);
        $result = $autocomplete->autocomplete(1, 'Аллерг');
        $this->assertArrayHasKey('Value', $result[0]);
        $this->assertArrayHasKey('Type', $result[0]);
        $this->assertArrayHasKey('Id', $result[0]);
        $this->assertArrayHasKey('Url', $result[0]);
    }
}

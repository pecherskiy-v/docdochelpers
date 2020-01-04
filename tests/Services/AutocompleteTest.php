<?php

namespace Pecherskiy\DocDoc\Tests\Services;

use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\RequiredFieldIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;
use Pecherskiy\DocDoc\Requests\Autocomplete;

class AutocompleteTest extends AbstractCategoryTest
{
    /**
     * @throws MethodIsNotSet
     * @throws RequiredFieldIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testAutocomplete(): void
    {
        // $autocomplete = new ServiceAutocomplete($this->client);
        $autocomplete = new Autocomplete($this->client);
        $autocomplete->city = 1;
        $autocomplete->search = 'Аллерг';
        $result = $autocomplete->autocomplete();
        static::assertObjectHasAttribute('Value', $result[0]);
        static::assertObjectHasAttribute('Type', $result[0]);
        static::assertObjectHasAttribute('Id', $result[0]);
        static::assertObjectHasAttribute('Url', $result[0]);
    }
}

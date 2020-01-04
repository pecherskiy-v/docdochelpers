<?php


namespace Pecherskiy\DocDoc\Entities;

use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\RequiredFieldIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;
use Pecherskiy\DocDoc\Requests\AbstractRequest;

class Autocomplete extends AbstractRequest
{
    /**
     * идентификатор города
     *
     * @var int $city
     * @example 1
     */
    public $city;

    /**
     * текст который пытаемся найти
     *
     * @var string $search
     * @example ак.
     */
    public $search;

    /**
     * 0 - осуществлять поиск по всем сущностям
     * 1 - не включать в результат поиска клиники
     *
     * Possible values:  1 , 0 .
     *
     * @var int $withoutClinics
     * @example 0
     */
    public $withoutClinics = true;

    /**
     * количество выводимых значений каждого типа.
     * Максимальное значение 15.
     * Default: 5.
     *
     * @var int
     * @example 3
     */
    public $count = 5;

    /**
     * типы, которые необходимо получить в выдаче, разделяются запятой.
     *
     * Possible values:  speciality , doctor , service , clinic , illness .
     *
     * @var array
     */
    public $types = [];

    /**
     * @return array
     * @throws RequiredFieldIsNotSet
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function autocomplete(): array
    {
        $this->requiredFields = [
            'city',
            'search'
        ];

        return $this->getOnly(
            "/autocomplete/{$this->makeRequestUrl()}",
            'Suggestions'
        );
    }
}

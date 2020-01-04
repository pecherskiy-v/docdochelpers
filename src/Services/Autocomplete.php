<?php

namespace Pecherskiy\DocDoc\Services;

use Pecherskiy\DocDoc\Exceptions\ResponseError;

/**
 * Class Autocomplete
 * @package Pecherskiy\DocDoc\Services
 */
class Autocomplete extends AbstractCategory
{
    /**
     * @param int $cityId
     * @param string $search
     * @param bool $withoutClinics
     * @return array
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    public function autocomplete(int $cityId, string $search, bool $withoutClinics = true): array
    {
        $without = (int)$withoutClinics;
        return $this->getOnly(
            "/autocomplete/city/{$cityId}/withoutClinics/{$without}?search={$search}",
            'Suggestions'
        );
    }
}

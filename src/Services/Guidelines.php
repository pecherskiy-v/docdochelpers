<?php

namespace Pecherskiy\DocDoc\Services;

use Pecherskiy\DocDoc\Exceptions\ResponseError;

/**
 * Class Guidelines
 * @package Pecherskiy\DocDoc\Services
 */
class Guidelines extends AbstractCategory
{
    /**
     * Get recommendations before taking
     *
     * @param int|null $sector
     * @param int|null $service
     * @param int|null $diagnostic
     * @return array
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    public function getGuidelines(int $sector = null, int $service = null, int $diagnostic = null): array
    {
        return $this->getOnly('/guidelines/?' . \http_build_query([
                'sector' => $sector,
                'service' => $service,
                'diagnostic' => $diagnostic,
            ]), 'Guidelines');
    }
}

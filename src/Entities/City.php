<?php

namespace Pecherskiy\DocDoc\Entities;

/**
 * DTO class
 * Class City
 *
 * @package Pecherskiy\DocDoc\Entities
 */
class City extends Entity
{
    protected const TYPES
        = [
            'id'            => 'int',
            'hasDiagnostic' => 'bool',
            'searchType'    => 'int',
            'timeZone'      => 'int',
            'latitude'      => 'float',
            'longitude'     => 'float',
        ];

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @var string
     */
    protected $phone;

    /**
     * @var float
     */
    protected $latitude;

    /**
     * @var float
     */
    protected $longitude;

    /**
     * @var int(1,2,3)
     */
    protected $searchType;

    /**
     * @var bool
     */
    protected $hasDiagnostic;

    /**
     * @var int
     */
    protected $timeZone;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @return int
     */
    public function getSearchType(): int
    {
        return $this->searchType;
    }

    /**
     * @return bool
     */
    public function isHasDiagnostic(): bool
    {
        return $this->hasDiagnostic;
    }

    /**
     * @return int
     */
    public function getTimeZone(): int
    {
        return $this->timeZone;
    }
}

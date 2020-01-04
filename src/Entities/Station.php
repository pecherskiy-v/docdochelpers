<?php

namespace Pecherskiy\DocDoc\Entities;

/**
 * DTO class station
 * Class Station
 *
 * @package Pecherskiy\DocDoc\Entities
 */
class Station extends Entity
{
    /**
     * {@inheritdoc}
     * @var array
     */
    protected const TYPES
        = [
            'id'          => 'integer',
            'cityId'      => 'integer',
            'districtIds' => 'array',
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
    protected $lineName;

    /**
     * @var string
     */
    protected $lineColor;

    /**
     * @var int
     */
    protected $cityId;

    /**
     * @var string
     */
    protected $alias;

    /**
     * @var array
     */
    protected $districtIds = [];

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
    public function getLineName(): string
    {
        return $this->lineName;
    }

    /**
     * @return string
     */
    public function getLineColor(): string
    {
        return $this->lineColor;
    }

    /**
     * @return int
     */
    public function getCityId(): int
    {
        return $this->cityId;
    }

    /**
     * @return string
     */
    public function getAlias(): string
    {
        return $this->alias;
    }

    /**
     * @return array
     */
    public function getDistrictIds(): array
    {
        return $this->districtIds;
    }
}

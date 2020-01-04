<?php

namespace Pecherskiy\DocDoc\Entities;

use function array_map;

/**
 * Default dto class
 * Class Entity
 *
 * @package Pecherskiy\DocDoc\Entities
 */
abstract class Entity
{
    /**
     * Field Type Matching
     * available types see in fill method
     *
     * @example ['Id' => 'int']
     *
     * @var array
     */
    protected const TYPES = [];

    /**
     * Entity constructor.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->fill($data);
    }

    /**
     * @param array $data
     *
     * @return Entity
     */
    protected function fill(array $data): Entity
    {
        foreach ($data as $prop => $value) {
            $type = static::TYPES[$prop] ?? 'string';

            switch ($type) {
                case 'integer':
                case 'int':
                    $this->$prop = (int)$value;
                    break;
                case 'float':
                    $this->$prop = (float)$value;
                    break;
                case 'boolean':
                case 'bool':
                    $this->$prop = (bool)$value;
                    break;
                case 'array':
                    $this->$prop = array_map(
                        static function (string $id) {
                            return (int)$id;
                        },
                        $value
                    );
                    break;
                default:
                    $this->$prop = $value;
            }
        }

        return $this;
    }
}

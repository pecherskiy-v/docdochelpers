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
    public function __construct(object $data)
    {
        $this->fill($data);
    }

    /**
     * @param array $data
     *
     * @return Entity
     */
    protected function fill(object $data): Entity
    {
        foreach ($data as $prop => $value) {
            $type = static::TYPES[$prop] ?? 'string';
            $propertyName = lcfirst($prop);

            switch ($type) {
                case 'integer':
                case 'int':
                    $this->$propertyName = (int)$value;
                    break;
                case 'float':
                    $this->$propertyName = (float)$value;
                    break;
                case 'boolean':
                case 'bool':
                    $this->$propertyName = (bool)$value;
                    break;
                case 'array':
                    $this->$propertyName = array_map(
                        static function (string $id) {
                            return (int)$id;
                        },
                        $value
                    );
                    break;
                default:
                    $this->$propertyName = $value;
            }
        }

        return $this;
    }
}

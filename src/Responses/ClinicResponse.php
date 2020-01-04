<?php


namespace Pecherskiy\DocDoc\Responses;


use Pecherskiy\DocDoc\Entities\Clinic;

use function is_bool;
use function is_int;
use function is_object;

class ClinicResponse
{
    public static function map($response): Clinic
    {
        $clinic = new Clinic();
        if (is_object($response)) {
            $array = (array)$response;
        } else {
            $array = $response;
        }
        foreach ($array as $key => $value) {
            $propertyName = lcfirst($key);
            // var_dump($propertyName);
            // var_dump($key);
            // var_dump($value);
            // var_dump(property_exists(Clinic::class, $propertyName));
            if (property_exists(Clinic::class, $propertyName)) {
                if (is_int($value)) {
                    $clinic->$propertyName = (int)$value;
                } elseif (is_bool($value)) {
                    $clinic->$propertyName = (bool)$value;
                } else {
                    $clinic->$propertyName = $value;
                }
            }
        }
        return $clinic;
    }
}

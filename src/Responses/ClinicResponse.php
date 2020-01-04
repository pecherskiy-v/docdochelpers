<?php


namespace Pecherskiy\DocDoc\Responses;


use Pecherskiy\DocDoc\Entities\Clinic;

use function is_bool;
use function is_int;

class ClinicResponse
{
    public static function map(array $response): Clinic
    {
        $clinic = new Clinic();
        foreach ($response as $key => $value) {
            if (property_exists(Clinic::class, $key)) {
                if (is_int($value)) {
                    $clinic->$key = (int)$value;
                } elseif (is_bool($value)) {
                    $clinic->$key = (bool)$value;
                }
            }
        }
        return $clinic;
    }
}

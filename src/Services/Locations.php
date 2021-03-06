<?php

namespace Pecherskiy\DocDoc\Services;

use Pecherskiy\DocDoc\Entities\City;
use Pecherskiy\DocDoc\Entities\Station;
use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;

use function array_map;
use function http_build_query;

/**
 * Class Locations
 * @package Pecherskiy\DocDoc\Services
 */
class Locations extends AbstractCategory
{
    /**
     * @return mixed
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function getCities()
    {
        return $this->getOnly('/city', 'CityList');
    }

    /**
     * Get a list of streets
     *
     * @param int $cityID
     * @return mixed
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function getStreets(int $cityID)
    {
        return $this->getOnly("/street/city/{$cityID}/", 'StreetList');
    }

    /**
     * Get a list of metro stations
     *
     * @param int $cityID
     * @return mixed
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function getMetro(int $cityID)
    {
        return $this->getOnly("/metro/city/{$cityID}/", 'MetroList');
    }

    /**
     * Get a list of districts
     *
     * @param int|null $cityId
     * @param int|null $areaId
     * @return array|object
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function getDistricts(int $cityId = null, int $areaId = null)
    {
        return $this->getOnly('/district/?' . http_build_query([
            'city' => $cityId,
            'area' => $areaId,
        ]), 'DistrictList');
    }

    /**
     * Get the nearest metro station by coordinates
     *
     * @param float $lat
     * @param float $lng
     * @param string $city
     * @return Station
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function nearestStationGeo(float $lat, float $lng, string $city = ''): Station
    {
        $query = "/nearestStationGeo/lat/{$lat}/lng/{$lng}/";
        if ('' !== $city) {
            $query .= "city/{$city}";
        }
        $this->client->setMethod($query);
        $response = $this->client->getJson();
        if (isset($response->Station)) {
            return new Station($response->Station);
        }
        throw new ResponseError($response->message ?? 'Response is error');
    }

    /**
     * Get a list of nearby areas
     *
     * @param int $districtID
     * @param int $limit
     * @return array|object
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function nearDistricts(int $districtID, int $limit = 50)
    {
        return $this->getOnly("/nearDistricts/id/{$districtID}/limit/{$limit}", 'DistrictList');
    }

    /**
     * Get a list of the nearest metro stations
     *
     * @param int $stationID
     * @return array|object
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function nearestStation(int $stationID)
    {
        return array_map(
            static function (object $station) {
            return new Station($station);
        }, $this->getOnly("/nearestStation/id/{$stationID}/", 'StationList'));
    }

    /**
     * Get the city by coordinates
     *
     * @param float $lat
     * @param float $lng
     * @return City
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function detectCity(float $lat, float $lng): City
    {
        return new City($this->getOnly("/detectCity/lat/{$lat}/lng/{$lng}", 'City'));
    }

    /**
     * @return array|object
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function getMoscowArea()
    {
        return $this->getOnly('/area', 'AreaList');
    }
}

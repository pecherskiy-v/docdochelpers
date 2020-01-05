<?php

namespace Pecherskiy\DocDoc\Tests\Services;

use Pecherskiy\DocDoc\Entities\Station;
use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;
use Pecherskiy\DocDoc\Services\Locations;

use function count;

class LocationsTest extends AbstractCategoryTest
{
    /**
     * @var array
     */
    protected $cities;

    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetCities(): void
    {
        $locations = new Locations($this->client);
        $result = $locations->getCities();
        static::assertIsArray($result);
        static::assertTrue(count($result) > 0);
        foreach ($result as $city) {
            static::assertObjectHasAttribute('Id', $city);
            static::assertObjectHasAttribute('Name', $city);
            static::assertObjectHasAttribute('Alias', $city);
            static::assertObjectHasAttribute('Phone', $city);
            static::assertObjectHasAttribute('Latitude', $city);
            static::assertObjectHasAttribute('Longitude', $city);
            static::assertObjectHasAttribute('SearchType', $city);
            static::assertObjectHasAttribute('HasDiagnostic', $city);
            static::assertObjectHasAttribute('TimeZone', $city);
        }
    }

    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetStreets(): void
    {
        $locations = new Locations($this->client);
        $cities = $this->getCities();
        $result = $locations->getStreets($cities[0]->Id);
        static::assertIsArray($result);
        static::assertArrayHasKey(0, $result);
        static::assertObjectHasAttribute('Id', $result[0]);
        static::assertObjectHasAttribute('CityId', $result[0]);
        static::assertObjectHasAttribute('Title', $result[0]);
        static::assertObjectHasAttribute('RewriteName', $result[0]);
    }

    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetMetro(): void
    {
        $locations = new Locations($this->client);
        $cities = $this->getCities();
        $result = $locations->getMetro($cities[0]->Id);
        static::assertIsArray($result);
        static::assertArrayHasKey(0, $result);
        static::assertObjectHasAttribute('Id', $result[0]);
        static::assertObjectHasAttribute('Alias', $result[0]);
        static::assertObjectHasAttribute('Name', $result[0]);
        static::assertObjectHasAttribute('LineName', $result[0]);
        static::assertObjectHasAttribute('LineColor', $result[0]);
        static::assertObjectHasAttribute('CityId', $result[0]);
        static::assertObjectHasAttribute('DistrictIds', $result[0]);
    }

    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetDistricts(): void
    {
        $locations = new Locations($this->client);
        $cities = $this->getCities();
        $result = $locations->getDistricts($cities[0]->Id);
        static::assertIsArray($result);
        static::assertArrayHasKey(0, $result);
        static::assertObjectHasAttribute('Id', $result[0]);
        static::assertObjectHasAttribute('Alias', $result[0]);
        static::assertObjectHasAttribute('Name', $result[0]);
        static::assertObjectHasAttribute('Area', $result[0]);
    }

    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testNearestStationGeo(): void
    {
        $locations = new Locations($this->client);
        $cities = $this->getCities();
        $result = $locations->nearestStationGeo($cities[0]->Latitude, $cities[0]->Longitude);
        static::assertInstanceOf(Station::class, $result);
    }

    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testNearDistricts(): void
    {
        $locations = new Locations($this->client);
        $cities = $this->getCities();
        $district = $locations->getDistricts($cities[0]->Id);
        $result = $locations->nearDistricts($district[0]->Id);
        static::assertIsArray($result);
        static::assertArrayHasKey(0, $result);
        static::assertObjectHasAttribute('Id', $result[0]);
        static::assertObjectHasAttribute('Alias', $result[0]);
        static::assertObjectHasAttribute('Name', $result[0]);
        static::assertObjectHasAttribute('Area', $result[0]);
    }

    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testNearestStation(): void
    {
        $locations = new Locations($this->client);
        $cities = $this->getCities();
        $stations = $locations->getMetro($cities[0]->Id);
        $result = $locations->nearestStation($stations[0]->Id);
        static::assertTrue(count($result) > 0);
        static::assertInstanceOf(Station::class, $result[0]);
    }

    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testDetectCity(): void
    {
        $locations = new Locations($this->client);
        $cities = $this->getCities();
        $result = $locations->detectCity($cities[0]->Latitude, $cities[0]->Longitude);
        static::assertEquals($result->getId(), (int)$cities[0]->Id);
    }

    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetMoscowArea(): void
    {
        $locations = new Locations($this->client);
        $result = $locations->getMoscowArea();
        static::assertTrue(count($result) > 0);
        foreach ($result as $area) {
            static::assertObjectHasAttribute('Id', $area);
            static::assertObjectHasAttribute('Alias', $area);
            static::assertObjectHasAttribute('Name', $area);
            static::assertObjectHasAttribute('FullName', $area);
        }
    }

    /**
     * @return array
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    protected function getCities(): array
    {
        if (null === $this->cities) {
            $locations = new Locations($this->client);
            $this->cities = $locations->getCities();
        }
        return $this->cities;
    }
}

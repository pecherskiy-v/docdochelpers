<?php

namespace Pecherskiy\DocDoc\Services;

use http\Exception\InvalidArgumentException;
use Pecherskiy\DocDoc\Exceptions\CityNumberIncorrect;
use Pecherskiy\DocDoc\Exceptions\InvalidArgument;
use Pecherskiy\DocDoc\Exceptions\MaximumCount;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Helpers\Builders\DoctorsQueryBuilder;

/**
 * Class Doctors
 * @package Pecherskiy\DocDoc\Services
 */
class Doctors extends AbstractCategory
{
    /**
     * Get all the doctors
     * returns array DoctorList and Total
     *
     * @param int $cityID
     * @param int $count
     * @param int $start
     * @return array|object
     * @throws CityNumberIncorrect
     * @throws MaximumCount
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    public function all(int $cityID, int $count = 500, int $start = 1)
    {
        if ($count > 500) {
            throw new MaximumCount('Maximum allowed count is 500');
        }
        $this->client->setMethod("/doctor/list/start/{$start}/count/{$count}/city/{$cityID}/");
        $response = $this->client->getJson();
        if ((int)$response['Total'] === 0) {
            throw new CityNumberIncorrect('Invalid city id passed');
        }
        if (isset($response['status']) && $response['status'] === 'error') {
            throw new ResponseError($response['message'] ?? 'Bad response');
        }

        return $response;
    }

    /**
     * Get a list of doctors
     *
     * @param DoctorsQueryBuilder $builder
     * @return array|object
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\RequiredFieldIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    public function getDoctors(DoctorsQueryBuilder $builder)
    {
        return $this->get("/doctor/list/{$builder->getQueryString()}", 'DoctorList');
    }

    /**
     * Get complete information about the doctor
     *
     * @param int $id
     * @param int|null $city
     * @param bool|null $withSlots
     * @param int|null $slotDays
     * @return mixed
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    public function find(int $id, int $city = null, bool $withSlots = null, int $slotDays = null)
    {
        return $this->getFirst("/doctor/{$id}/?" . \http_build_query([
            'city' => $city,
            'withSlots' => $withSlots !== null ? (int)$withSlots : null,
            'slotDays' => $slotDays,
        ]), 'Doctor');
    }

    /**
     * Get complete information about the doctor by alias
     *
     * @param string $alias
     * @param int|null $city
     * @return mixed
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    public function findByAlias(string $alias, int $city = null)
    {
        return $this->getFirst("/doctor/by/alias/{$alias}/?" . \http_build_query([
            'city' => $city,
        ]), 'Doctor');
    }

    /**
     * Get reviews about the doctor
     *
     * @param int $id
     * @return array|object
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    public function getReviews(int $id)
    {
        return $this->getOnly("/review/doctor/{$id}", 'ReviewList');
    }

    /**
     * Get a list of special values
     *
     * @param int $cityID
     * @param int $onlySimple
     * onlySimple Уникальный специализации.
     * 0 - не обращать внимание на уникальность специальности, выбирать с двойными
     * 1 - получать только уникальные специальности (стоит по умолчанию)
     * @return mixed
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    public function getSpecialities(int $cityID, int $onlySimple = 1)
    {
        return $this->getOnly("/speciality/city/{$cityID}/onlySimple/{$onlySimple}", 'SpecList');
    }

    public function getAllSpecialities()
    {
        return $this->getOnly('/speciality', 'SpecList');
    }

    /**
     * Get a list of services
     *
     * @return mixed
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    public function getServices()
    {
        return $this->getOnly('/service/list', 'ServiceList');
    }

    /**
     * Get a list of slots for doctors and diagnostics
     *
     * @param int $id
     * @param int $clinicId
     * @param \DateTime $startDate
     * @param \DateTime $finishDate
     * @param string $type
     * @return array|object
     * @throws InvalidArgument
     * @throws ResponseError
     * @throws \Pecherskiy\DocDoc\Exceptions\MethodIsNotSet
     * @throws \Pecherskiy\DocDoc\Exceptions\Unauthorized
     */
    public function getSlots(int $id, int $clinicId, \DateTime $startDate, \DateTime $finishDate, $type = 'doctor')
    {
        if ($type !== 'doctor' && $type !== 'diagnostic') {
            throw new InvalidArgument('For the argument "type" valid parameters: doctor and diagnosis');
        }

        return $this->getOnly("/slot/list/{$type}/{$id}/clinic/{$clinicId}/" .
            "from/{$startDate->format('Y-m-d')}/to/{$finishDate->format('Y-m-d')}", 'SlotList');
    }
}

<?php

namespace Pecherskiy\DocDoc\Requests;

use Pecherskiy\DocDoc\Entities\Doctor;
use Pecherskiy\DocDoc\Exceptions\CityNumberIncorrect;
use Pecherskiy\DocDoc\Exceptions\MaximumCount;
use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\RequiredFieldIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;

/**
 * Class Doctors
 *
 * @package Pecherskiy\DocDoc\Services
 */
class Doctors extends AbstractRequest
{
    public $repalseProperty
        = [
            'naDom' => 'na_dom',
        ];

    /**
     * Required
     *
     * @var int
     */
    public $start = 0;

    /**
     * Required
     *
     * @var int
     */
    public $count = 500;

    /**
     * Required
     *
     * @var int
     */
    public $city;

    /**
     * @var int
     */
    public $speciality;

    /**
     * @var int
     */
    public $area;

    /**
     * @var int
     */
    public $district;

    /**
     * Required
     *
     * @var array
     */
    public $stations = [];

    /**
     * Required
     *
     * @var string("strict", "mixed", "extra")
     */
    public $near = 'strict';

    /**
     * @var string("price", "experience", "rating", "distance", "name")
     */
    public $order;

    /**
     * @var bool
     */
    public $deti;

    /**
     * @var bool
     */
    public $naDom;

    /**
     * @var string("landing")
     */
    public $type;

    /**
     * @var int
     */
    public $lat;

    /**
     * @var int
     */
    public $lng;

    /**
     * @var int
     */
    public $radius;

    /**
     * @var int
     */
    public $street;

    /**
     * @var bool
     */
    public $withSlots;

    /**
     * @var int
     */
    public $slotsDays;

    /**
     * if male = 1, if female = 2
     *
     * @var int(1,2)
     */
    public $gender;

    /**
     * @var bool
     */
    public $withReviews;

    /**
     * @var bool
     */
    public $splitClinic;

    /**
     * Идентификатор клиники (можно передавать список через запятую)
     * @var string
     * @example 5343
     * @example 5343,230
     */
    public $clinicId;

    /**
     * @var int
     * @example 10
     */
    public $extraLimit;

    /**
     * @var string
     * @example 2017-12-20 10:10
     */
    public $workingTime;

    /**
     * @var int
     * @example 1
     */
    public $withoutAdultsReception;

    /**
     * @var int
     * @example 1
     */
    public $adults;

    /**
     * @var int
     * @example 5343
     */
    public $singleClinicId;

    /**
     * @var int
     */
    public $illness;

    /**
     * Get all the doctors
     * returns array DoctorList and Total
     *
     * @return array|object
     * @throws CityNumberIncorrect
     * @throws MaximumCount
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     * @throws RequiredFieldIsNotSet
     */
    public function all()
    {
        if ($this->count > 500) {
            throw new MaximumCount('Maximum allowed count is 500');
        }
        $response = $this->getDoctors(false);
        if (0 === (int)$response->Total) {
            throw new CityNumberIncorrect('Invalid city id passed');
        }
        if (isset($response->status) && 'error' === $response->status) {
            throw new ResponseError($response->message ?? 'Bad response');
        }

        return $response;
    }

    /**
     * Get a list of doctors
     *
     * @param bool $doctorsListOnly
     *
     * @return array|object|
     * @throws MethodIsNotSet
     * @throws RequiredFieldIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function getDoctors(bool $doctorsListOnly = true)
    {
        $this->requiredFields = [
            'start',
            'count',
            'city',
            'stations',
            'near',
        ];

        $doctorsList = [];
        $result = $this->get("/doctor/list/{$this->makeRequestUrl()}", 'DoctorList');
        foreach ($result->DoctorList as $clinic) {
            $doctorsList[] = new Doctor($clinic);
        }
        if ($doctorsListOnly) {
            return $doctorsList;
        }
        $result->DoctorList = $doctorsList;
        return $result;
    }

    /**
     * Get complete information about the doctor
     *
     * @param int $id
     *
     * @return mixed
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function find(int $id)
    {
        return new Doctor($this->getFirst("/doctor/{$id}/", 'Doctor'));
    }

    /**
     * Get complete information about the doctor by alias
     *
     * @param string   $alias
     * @param int|null $city
     *
     * @return mixed
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function findByAlias(string $alias, int $city = null): Doctor
    {
        $cityStr = '';
        if (null !== $city) {
            $cityStr = 'city/' . $city;
        }
        return new Doctor(
            $this->getFirst(
                "/doctor/by/alias/{$alias}/" . $cityStr,
                'Doctor'
            )
        );
    }

    /**
     * Get reviews about the doctor
     *
     * @param int $id
     *
     * @return array|object
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
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
     * 0 - не обращать внимание на уникальность специальности, выбирать с
     * двойными
     * 1 - получать только уникальные специальности (стоит по умолчанию)
     *
     * @return mixed
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function getSpecialities(int $cityID, int $onlySimple = 1)
    {
        return $this->getOnly(
            "/speciality/city/{$cityID}/onlySimple/{$onlySimple}",
            'SpecList'
        );
    }

    /**
     * @param int $cityID
     *
     * @return array|object
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function getAllSpecialities(int $cityID)
    {
        return $this->getOnly("/speciality/city/{$cityID}", 'SpecList');
    }

    /**
     * Get a list of services
     *
     * @return mixed
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function getServices()
    {
        return $this->getOnly('/service/list', 'ServiceList');
    }
}

<?php

namespace Pecherskiy\DocDoc\Requests;

use Carbon\Carbon;
use Pecherskiy\DocDoc\Entities\Clinic;
use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\RequiredFieldIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;
use Pecherskiy\DocDoc\Responses\ClinicResponse;

/**
 * Class Clinics
 * @package Pecherskiy\DocDoc\Services
 */
class Clinics extends AbstractRequest
{
    /**
     * Начиная с какого порядкового номера вернуть список
     *
     * @var int
     */
    public $start = 0;

    /**
     * Сколько должно быть в списке
     *
     * @var int
     */
    public $count = 500;

    /**
     * Идентификатор города
     *
     * @var int
     */
    public $city;

    /**
     * Тип клиники:
     * 1 - Клиника
     * 2 - Диаг. центр
     * 3 - Частный врач
     * Optional
     * @var int[]
     * @example [1,2,3]
     */
    public $type = [];

    /**
     * Идентификатор(ы) станций метро
     *
     * @var int[]
     */
    public $stations = [];

    /**
     * Режим поиска рядом:
     * strict — строгое совпадение по станциям
     * mixed — строгое совпадение по станциям, а потом поиск по ближайшим
     * extra - строгое совпадение по станциям, а потом поиск по ближайшим и лучшим (добивка до 10 врачей)
     *
     * @var string("strict", "mixed", "extra")
     */
    public $near;

    /**
     * Поиск по полу врача:
     * 1 - мужской
     * 2 - женский
     * @var int
     */
    public $gender;

    /**
     * Идентификатор специальности
     * @var int
     */
    public $speciality;

    /**
     * Идентификатор диагностики
     * @var int
     */
    public $diagnostic;

    /**
     * Идентификатор района или имя
     * @var string|int
     */
    public $district;

    /**
     * Идентификатор улицы
     * @var int
     */
    public $street;

    /**
     * Сортировка: name — по названию клиники Если не указано, то сортируется по рейтингу
     * @var string
     * @example name
     */
    public $order;

    /**
     * 0 - клиника работает НЕ круглосуточно
     * 1 - клиника работает круглосуточно круглосуточно каждый день с 00:00 по 24:00, включая выходные
     * @var bool
     */
    public $workAllTime;

    /**
     * идентификатор(ы) клиники, если несколько - указываются через запятую
     *
     * @var int[] $clinicId
     * @example [1,233,321]
     */
    public $clinicId = [];

    /**
     * Дата и время на которую есть рабочее время или слоты врачей в клинике.
     * Необходимо передавать местное время выбранного города.
     *
     * @var string
     * @example 2017-12-20 10:10
     */
    public $workingTime;

    /**
     * выбор врачей:
     * 0 - не выезжающих на дом
     * 1 - выезжающих на дом
     * @var bool
     */
    public $naDom;

    /**
     * Тип выборки
     * diagnostic, doctor
     * @var string $kind
     * @example doctor
     */
    public $kind;

    /**
     * фильтрация по приему взрослых.
     * 0 - не принимают взрослых
     * 1 - принимают взрослых
     *
     * @var int $adults
     */
    public $adults;

    /**
     * фильтрация по приему детей.
     * 0 - не принимают детей
     * 1 - принимают детей
     *
     * @var int
     * @example 1
     */
    public $deti;

    /**
     * поиск по названию клиники
     *
     * @var string $search
     * @example см.
     */
    public $search;

    /**
     * @param bool $clinicsOnly
     *
     * @return array|object|Clinic[]
     * @throws MethodIsNotSet
     * @throws RequiredFieldIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function getClinics(bool $clinicsOnly = true)
    {
        $this->requiredFields = [
            'start',
            'count',
            'city',
        ];

        $clinicList = [];
        $result = $this->get("/clinic/list/{$this->makeRequestUrl()}", 'ClinicList');
        foreach ($result->ClinicList as $clinic) {
            $clinicList[] = ClinicResponse::map($clinic);
        }
        if ($clinicsOnly) {
            return $clinicList;
        }
        $result->ClinicList = $clinicList;
        return $result;
    }

    /**
     * Get full information about the clinic
     *
     * @param int $id
     * @return Clinic
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function find(int $id):Clinic
    {
        return ClinicResponse::map($this->getFirst("/clinic/{$id}", 'Clinic'));
    }

    /**
     * Get complete information about the clinic by alias
     *
     * @param string $alias
     * @param int|null $city
     * @return Clinic
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function findByAlias(string $alias, int $city = null): Clinic
    {
        $cityStr = '';
        if (null !== $city) {
            $cityStr = 'city/' . $city;
        }
        return  ClinicResponse::map(
            $this->getFirst(
                "/clinic/by/alias/{$alias}/" . $cityStr,
                'Center'
            )
        );
    }

    /**
     * Get reviews about the doctor
     *
     * @param int $id
     * @return array|object
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function getReviews(int $id)
    {
        return $this->getOnly("/review/clinic/{$id}", 'ReviewList');
    }

    /**
     * Getting the count of clinics
     *
     * @return array|object
     * @throws MethodIsNotSet
     * @throws RequiredFieldIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function clinicCount()
    {
        $this->repalseProperty = [
            'city' => 'cityID',
            'type' => 'clinicType',
        ];
        $this->client->setMethod("/clinic/count/{$this->makeRequestUrl()}");
        $response = $this->client->getJson();
        if (isset($response->Total)) {
            return $response;
        }
        throw new ResponseError($response->message ?? 'Response is error');
    }

    /**
     * @param int    $doctorId
     * @param int    $clinicId
     * @param Carbon $from
     * @param Carbon $to
     *
     * @return array|object
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function slotListByDoctor(int $doctorId, int $clinicId, Carbon $from, Carbon $to)
    {
        return $this->getOnly("/slot/list/doctor/{$doctorId}/clinic/{$clinicId}/from/{$from->format('Y-m-d')}/to/{$to->format('Y-m-d')}", 'SlotList');
    }

    /**
     * @param int    $diagnosticId
     * @param int    $clinicId
     * @param Carbon $from
     * @param Carbon $to
     *
     * @return array|object
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function slotListByDiagnostic(int $diagnosticId, int $clinicId, Carbon $from, Carbon $to)
    {
        return $this->getOnly("/slot/list/diagnostic/{$diagnosticId}/clinic/{$clinicId}/from/{$from->format('Y-m-d')}/to/{$to->format('Y-m-d')}", 'SlotList');
    }

    /**
     * Get a list of images of the clinic
     *
     * @param int $clinicID
     * @return array|object
     * @throws ResponseError
     * @throws MethodIsNotSet
     * @throws Unauthorized
     */
    public function getClinicImages(int $clinicID)
    {
        return $this->getOnly("/clinic/gallery/{$clinicID}/", 'ImageList');
    }
}

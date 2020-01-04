<?php

namespace Pecherskiy\DocDoc\Helpers\Builders;

class ClinicsQueryBuilder extends QueryBuilder
{
    /**
     * {@inheritDoc}
     */
    public const REQUIRED_FIELDS = [
        'start',
        'count',
        'city',
    ];

    public const GET_NOT_ALLOWED = [
        'start',
        'count',
        'city',
        'type',
        'district',
        'stations',
        'near',
        'na_dom',
        'speciality',
        'clinicId',
        'diagnostic',
        'street',
        'order',
        'workAllTime',
        'gender',
        'workingTime',
    ];

    /**
     * Начиная с какого порядкового номера вернуть список
     * Required
     * @var int
     */
    protected $start = 0;

    /**
     * Сколько должно быть в списке
     * Required
     * @var int
     */
    protected $count = 500;

    /**
     * Идентификатор города
     * Required
     * @var int
     */
    protected $city;

    /**
     * Тип клиники:
     * 1 - Клиника
     * 2 - Диаг. центр
     * 3 - Частный врач
     * Optional
     * @var array(1,2,3)
     */
    protected $type = [];

    /**
     * Идентификатор(ы) станций метро
     * Required
     * @var array
     */
    protected $stations = [];

    /**
     * Режим поиска рядом:
     * strict — строгое совпадение по станциям
     * mixed — строгое совпадение по станциям, а потом поиск по ближайшим
     * extra - строгое совпадение по станциям, а потом поиск по ближайшим и лучшим (добивка до 10 врачей)
     * Required
     * @var string("strict", "mixed", "extra")
     */
    protected $near;

    /**
     * Идентификатор специальности
     * @var int
     */
    protected $speciality;

    /**
     * Идентификатор диагностики
     * @var int
     */
    protected $diagnostic;

    /**
     * Идентификатор района или имя
     * @var string|int
     */
    protected $district;

    /**
     * Идентификатор улицы
     * @var int
     */
    protected $street;

    /**
     * Сортировка: name — по названию клиники Если не указано, то сортируется по рейтингу
     * @var string("name")
     */
    protected $order;

    /**
     * 0 - клиника работает НЕ круглосуточно
     * 1 - клиника работает круглосуточно круглосуточно каждый день с 00:00 по 24:00, включая выходные
     * @var bool
     */
    protected $workAllTime;

    /**
     * выбор врачей:
     * 0 - не выезжающих на дом
     * 1 - выезжающих на дом
     * @var bool
     */
    protected $na_dom;

    /**
     * идентификатор(ы) клиники, если несколько - указываются через запятую
     * @var array(1,233,321)
     */
    protected $clinicId = [];

    /**
     * Поиск по полу врача:
     * 1 или male - мужской
     * 2 или female - женский
     * @var string|int
     */
    protected $gender;

    /**
     * Дата и время на которую есть рабочее время или слоты врачей в клинике.
     * Необходимо передавать местное время выбранного города.
     * Пример 2017-12-20 10:10
     * @var string
     */
    protected $workingTime;

    /**
     * @param int $start
     * @return ClinicsQueryBuilder
     */
    public function setStart(int $start): ClinicsQueryBuilder
    {
        $this->start = $start;

        return $this;
    }

    /**
     * @param int $count
     * @return ClinicsQueryBuilder
     */
    public function setCount(int $count): ClinicsQueryBuilder
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @param int $city
     * @return ClinicsQueryBuilder
     */
    public function setCity(int $city): ClinicsQueryBuilder
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @param array $clinicType
     * @return ClinicsQueryBuilder
     */
    public function setType(array $clinicType): ClinicsQueryBuilder
    {
        $this->type = $clinicType;

        return $this;
    }

    /**
     * @param array $stations
     * @return ClinicsQueryBuilder
     */
    public function setStations(array $stations): ClinicsQueryBuilder
    {
        $this->stations = $stations;

        return $this;
    }

    /**
     * @param string $nearMode
     * @return ClinicsQueryBuilder
     */
    public function setNearMode(string $nearMode): ClinicsQueryBuilder
    {
        $this->nearMode = $nearMode;

        return $this;
    }

    /**
     * @param int $speciality
     * @return ClinicsQueryBuilder
     */
    public function setSpeciality(int $speciality): ClinicsQueryBuilder
    {
        $this->speciality = $speciality;

        return $this;
    }

    /**
     * @param int $diagnostic
     * @return ClinicsQueryBuilder
     */
    public function setDiagnostic(int $diagnostic): ClinicsQueryBuilder
    {
        $this->diagnostic = $diagnostic;

        return $this;
    }

    /**
     * @param int|string $district
     * @return ClinicsQueryBuilder
     */
    public function setDistrict($district): ClinicsQueryBuilder
    {
        $this->district = $district;

        return $this;
    }

    /**
     * @param int $street
     * @return ClinicsQueryBuilder
     */
    public function setStreet(int $street): ClinicsQueryBuilder
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @param string $order
     * @return ClinicsQueryBuilder
     */
    public function setOrder(string $order): ClinicsQueryBuilder
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @param bool $workAllTime
     * @return ClinicsQueryBuilder
     */
    public function setWorkAllTime(bool $workAllTime): ClinicsQueryBuilder
    {
        $this->workAllTime = $workAllTime;

        return $this;
    }

    /**
     * @param bool $na_dom
     * @return ClinicsQueryBuilder
     */
    public function setNaDom(bool $na_dom): ClinicsQueryBuilder
    {
        $this->na_dom = $na_dom;

        return $this;
    }

    /**
     * @param array $clinicId
     * @return ClinicsQueryBuilder
     */
    public function setClinicId(array $clinicId): ClinicsQueryBuilder
    {
        $this->clinicId = $clinicId;

        return $this;
    }

    /**
     * @param int|string $gender
     * @return ClinicsQueryBuilder
     */
    public function setGender($gender): ClinicsQueryBuilder
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * @param string $workingTime
     * @return ClinicsQueryBuilder
     */
    public function setWorkingTime(string $workingTime): ClinicsQueryBuilder
    {
        $this->workingTime = $workingTime;

        return $this;
    }
}

<?php


namespace Pecherskiy\DocDoc\Entities;


class Clinic extends Entity
{
    /**
     * @var int
     * @example 10
     */
    public $id;
    /**
     * @var string
     * @example "Евразия"
     */
    public $name;
    /**
     * @var string
     * @example "Евразия"
     */
    public $shortName;
    /**
     * @var string
     * @example "evraziya"
     */
    public $rewriteName;
    /**
     * @var string
     * @example "http://www.ru03.ru"
     */
    public $url;
    /**
     * @var string
     * @example "Москва"
     */
    public $city;
    /**
     * @var string
     * @example "1-й Волконский пер."
     */
    public $street;
    /**
     * @var string
     * @example "6289"
     */
    public $streetId;

    /**
     * @var string
     * @example "д. 15"
     */
    public $house;

    /**
     * @var string
     * @example "Многопрофильный медицинский центр. Осуществляет консультативный и диагностический приём взрослых. Расположен в 7 мин. ходьбы от м. Авиомоторная. В клинике работают специалисты по направлениям аллергологии, иммунологии, нефрологии и т.п."
     */
    public $description;

    /**
     * @var string
     * @example "Многопрофильный медицинский центр. Осуществляет консультативный и диагностический приём взрослых. Расположен в 7 мин. ходьбы от м. Авиомоторная. В клинике работают специалисты по направлениям аллергологии, иммунологии, нефрологии и т.п."
     */
    public $shortDescription;
    /**
     * @var string
     * @example "+74959270101"
     */
    public $phone;

    /**
     * @var string
     * @example "+7 (495) 647-42-47"
     */
    public $phoneAppointment;
    /**
     * @var string
     * @example "https://s.nzorin.docdoc.pro/img/clinic/logo/min_10.jpg?1508410486"
     */
    public $logo;
    /**
     * @var string
     * @example "https://s.nzorin.docdoc.pro/img/clinic/logo/min_10.jpg?1508410486"
     */
    public $logoPath;

    /**
     * @var string
     * @example 'disable'
     */
    public $scheduleState;

    /**
     * @var int
     * @example 5
     */
    public $districtId;

    /**
     * @var string
     * @example "contact@astramed-clinic.ru"
     */
    public $email;

    /**
     * @var string
     */
    public $replacementPhone;

    /**
     * @var string
     */
    public $minPrice;
    /**
     * @var string
     */
    public $maxPrice;

    /**
     * @var int[]
     */
    public $doctors;
    /**
     * @var string
     * @example "37.6177790000"
     */
    public $longitude;
    /**
     * @var string
     * @example "55.7747250000"
     */
    public $latitude;
    /**
     * @var bool
     */
    public $onlineRecordDoctor;

    /**
     * @var bool
     */
    public $isActive;

    /**
     * @var array
     */
    public $specialities;

    /**
     * @var float
     */
    public $order;
    /**
     * @var float
     */
    public $rating;
    /**
     * @var string
     * @example "многопрофильный медицинский центр"
     */
    public $typeOfInstitution;

    /**
     * @var int
     */
    public $parentId;

    /**
     * @var int[]
     */
    public $branchesId;

    /**
     * @var int
     */
    public $highlightDiscount;

    /**
     * @var array
     * @example [
    {
    "Id": "42",
    "Name": "Достоевская",
    "Alias": "dostoevskaya",
    "LineId": "10",
    "Longitude": 37.61471558,
    "Latitude": 55.7814827,
    "LineColor": "99cc33",
    "TimeWalking": 954
    }
    ]
     */
    public $stations;

    public $lowCostDoctor;
// "LowCostDoctor": {
//     "Rating": 4.75,
//     "Price": 500
// },

    /**
     * @var object
     *
     * @example
     * "Total": 2,
     * "ServiceList": [
            {
                "ServiceId": "13",
                "ServiceName": "Консультация андролога первичная",
                "Price": "500",
                "SpecialPrice": "400"
            },
            {
                "ServiceId": "1642",
                "ServiceName": "Консультация гинеколога первичная",
                "Price": "1200",
                "SpecialPrice": "400"
            }
        ]
     */
    public $services;

    /**
     * @var array
     * @example [
            {
                Day: "0",
                StartTime: "10:00",
                EndTime: "20:00",
                DayTitle: "пн-пт"
            }
        ]
     */
    public $schedule;

    /**
     * @var array
     * @example [
            {
                "Id": "52",
                "Name": "МРТ (магнитно-резонансная томография) придаточных пазух носа",
                "Price": "5000",
                "SpecialPrice": "3500",
                "DeparturePriceFrom": 10000
            }
        ]
     */
    public $diagnostics;
}

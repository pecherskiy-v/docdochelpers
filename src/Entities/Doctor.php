<?php


namespace Pecherskiy\DocDoc\Entities;


class Doctor extends Entity
{
    /**
     * Уникальный идентификатор врача
     * required
     *
     * @var int
     */
    public $id;

    /**
     * ФИО врача
     *
     * @var string
     * required
     */
    public $name;

    /**
     * Фамилия врача
     * required
     *
     * @var string
     *
     * @example Иванов
     */
    public $surname;

    /**
     * Алиас для ЧПУ
     * required
     *
     * @var string
     */
    public $alias;

    /**
     * Рейтинг DocDoc врача
     * required
     *
     * @var string
     */
    public $rating;

    /**
     * Текстовое описание рейтинга DocDoc врача
     * required
     *
     * @var string
     */
    public $ratingLabel;

    /**
     * Пол специалиста
     * required
     *
     * enum
     */
    public $sex;

    /**
     * Адрес фотографии специалиста
     * required
     *
     * @var string
     */
    public $img;


    /**
     * Путь к фото врача в пропорции 640*400. null в случае отсутствия фото
     * required
     *
     * @var string
     */
    public $imgFormat;

    /**
     * Добавочный номер телефона
     * required
     *
     * @var string
     */
    public $addPhoneNumber;


    /**
     * Категория врача (e.g. "1-я категория")
     * required
     *
     * @var string
     */
    public $category;

    /**
     * Ученая степень
     * required
     *
     * @var string
     */
    public $degree;

    /**
     * Ранг (e.r. "Доцент", "Профессор")
     * required
     *
     * @var string
     */
    public $rank;

    /**
     * Описание врача
     * required
     *
     * @var string
     */
    public $description;

    /**
     * Стаж специалиста
     * required
     *
     * @var int
     */
    public $experienceYear;

    /**
     * Стоимость первичного приема
     * required
     *
     * @var int
     */
    public $price;

    /**
     * Специальная стоимость приема
     * required
     *
     * @var int
     */
    public $specialPrice;


    /**
     * var enum
     */
    public $departure;

    /**
     * @var array
     */
    public $clinics;

    /**
     * @var array
     */
    public $specialities;

    /**
     * @var array
     */
    public $stations;

    /**
     * @var array
     */
    public $bookingClinics;

    /**
     * Активность доктора
     * required
     *
     * @var bool
     */
    public $isActive;


    /**
     * Внутренний рейтинг ДокДок врача
     * required
     *
     * @var int
     */
    public $internalRating;

    /**
     * Число отзывов
     * required
     *
     * @var int
     */
    public $opinionCount;

    /**
     * Информация о враче
     * required
     *
     * @var string
     */
    public $textAbout;

    /**
     * Признак того, что данный врач из добивки (null / geo / best)
     *
     * @var string
     */
    public $extra;

    /**
     * var enum
     */
    public $kidsReception;

    /**
     * @var array
     */
    public $clinicsInfo;

    /**
     * @var array
     */
    public $telemed;

    /**
     * Id клиники в фокусе
     * required
     *
     * @var int
     */
    public $focusClinic;

    /**
     * required
     *
     * @var object
     */
    public $slots;

    /**
     * @var array
     */
    public $intervals;

    /**
     * Рейтинг DocDoc врача по отзывам
     * required
     *
     * @var string
     */
    public $ratingReviewsLabel;

    /**
     * Уникальная цена
     * required
     *
     * @var bool
     */
    public $isExclusivePrice;

    /**
     * текстовое описание образования
     * required
     *
     * @var string
     * @example Витебский государственный...
     */
    public $textEducation;

    /**
     * текстовое описание стажа
     * required
     *
     * @var string
     * @example Эндокринолог, "Городская поликлиника...
     */
    public $textExperience;

    /**
     * текстовое описание пройденных курсов
     * required
     *
     * @var string
     * @example Общая терапевтическая билиопанкреатология
     */
    public $textCourse;

    /**
     * текстовое описание специализации
     * required
     *
     * @var string
     *
     * @example Профилактика и лечение
     */
    public $textSpec;

    /**
     * текстовое описание присутствия в сообществах
     * required
     *
     * @var string
     * @example Член Всероссийской ассоциации онкологов
     */
    public $textAssociation;

    /**
     * Врач высшей категории. Кандидат медицинских наук.
     * required
     *
     * @var string
     * @example Научное звание
     */
    public $textDegree;

    /**
     * Достижения врача
     *
     * @var object
     */
    public $achievements;

    /**
     * Болезни, на которых специализируется врач
     *
     * @var array
     * */
    public $specialization;
}
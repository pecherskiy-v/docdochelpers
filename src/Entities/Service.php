<?php


namespace Pecherskiy\DocDoc\Entities;

class Service extends Entity
{
    /**
     * идентификатор услуги
     * required
     *
     * @var string
     */
    public $id;

    /**
     * название услуги
     * required
     *
     * @var string
     */
    public $name;

    /**
     * левая позиция в дереве
     * required
     *
     * @var string
     */
    public $lft;

    /**
     * правая позиция в дереве
     * required
     *
     * @var string
     */
    public $rgt;

    /**
     * уровень вложенности
     * required
     *
     * @var string
     */
    public $depth;

    /**
     * id специализации
     *
     * @var string
     */
    public $sectorId;

    /**
     * id диагностики, связанной с этой услугой
     *
     * @var string
     */
    public $diagnosticId;
}
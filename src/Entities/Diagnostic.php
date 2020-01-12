<?php

namespace Pecherskiy\DocDoc\Entities;

class Diagnostic extends Entity
{
    public $id;
    public $name;
    public $alias;
    /**
     * @var Diagnostic[]
     */
    public $subDiagnosticList;
}

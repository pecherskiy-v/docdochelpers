<?php


namespace Pecherskiy\DocDoc\Requests;

use Pecherskiy\DocDoc\Entities\Diagnostic;
use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;

class Service extends AbstractRequest
{
    /**
     * @return Diagnostic[]
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function getDiagnostic(): array
    {
        foreach ($this->getOnly('/diagnostic', 'DiagnosticList') as $diagnosticItem) {
            $diagnosticList[] = new Diagnostic($diagnosticItem);
        }
        return $diagnosticList??[];
    }
}

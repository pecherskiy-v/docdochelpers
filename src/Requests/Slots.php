<?php


namespace Pecherskiy\DocDoc\Requests;

use Carbon\Carbon;
use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;

class Slots extends AbstractRequest
{
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
}

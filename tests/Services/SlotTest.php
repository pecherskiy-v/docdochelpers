<?php

namespace Pecherskiy\DocDoc\Tests\Services;

use Carbon\Carbon;
use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;
use Pecherskiy\DocDoc\Requests\Slots;

class SlotTest extends AbstractCategoryTest
{
    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testSlotListDiagnostic(): void
    {
        $slot = new Slots($this->client);
        $from = Carbon::now();
        $to = Carbon::now()->addDays(7);
        $result = $slot->slotListByDiagnostic(52, 105, $from, $to);
        static::assertObjectHasAttribute('Id', $result[0]);
        static::assertObjectHasAttribute('StartTime', $result[0]);
        static::assertObjectHasAttribute('FinishTime', $result[0]);
    }

    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testSlotListDoctor(): void
    {
        $slot = new Slots($this->client);
        $from = Carbon::now();
        $to = Carbon::now()->addDays(3);
        $result = $slot->slotListByDoctor(30, 230, $from, $to);
        static::assertObjectHasAttribute('Id', $result[0]);
        static::assertObjectHasAttribute('StartTime', $result[0]);
        static::assertObjectHasAttribute('FinishTime', $result[0]);
    }
}

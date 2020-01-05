<?php

namespace Pecherskiy\DocDoc\Tests\Services;

use Pecherskiy\DocDoc\Entities\Clinic;
use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\RequiredFieldIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;

use Pecherskiy\DocDoc\Requests\Clinics;

use function count;

class ClinicsTest extends AbstractCategoryTest
{
    protected $clinic;

    /**
     * @throws MethodIsNotSet
     * @throws RequiredFieldIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetClinicsRequiredFields(): void
    {
        $this->expectException(RequiredFieldIsNotSet::class);
        $clinics = new Clinics($this->client);
        $clinics->getClinics();
    }

    /**
     * @throws RequiredFieldIsNotSet
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetClinicsRequiredFieldCityId(): void
    {
        $this->expectException(RequiredFieldIsNotSet::class);
        $clinics = new Clinics($this->client);
        $clinics->count = 1;
        $clinics->start = 0;
        $clinics->getClinics();
    }

    /**
     * @throws RequiredFieldIsNotSet
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetClinicsSimpleQuery(): void
    {
        $clinics = new Clinics($this->client);
        $clinics->start = 0;
        $clinics->count = 1;
        $clinics->city = 1;
        $result = $clinics->getClinics(false);
        static::assertObjectHasAttribute('Total', $result);
        static::assertObjectHasAttribute('ClinicList', $result);
        static::assertEquals(count($result->ClinicList), 1);
        static::assertObjectHasAttribute('id', $result->ClinicList[0]);
    }

    /**
     * @throws RequiredFieldIsNotSet
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetClinicsStartFrom(): void
    {
        $clinics = new Clinics($this->client);
        $clinics->start = 0;
        $clinics->count = 1;
        $clinics->city = 1;
        $resultA = $clinics->getClinics();

        $clinics->start = 1;
        $resultB = $clinics->getClinics();
        static::assertNotEquals($resultA[0]->id, $resultB[0]->id);
    }

    /**
     * @throws RequiredFieldIsNotSet
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetClinicsCityId(): void
    {
        $clinics = new Clinics($this->client);
        $clinics->start = 0;
        $clinics->count = 1;
        $clinics->city = 1;
        $resultA = $clinics->getClinics();

        $clinics->city = 2;
        $resultB = $clinics->getClinics();

        static::assertNotEquals($resultA[0]->id, $resultB[0]->id);
    }

    /**
     * @throws RequiredFieldIsNotSet
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetClinicsStation(): void
    {
        $clinics = new Clinics($this->client);

        $clinics->start = 0;
        $clinics->count = 1;
        $clinics->city = 1;
        $clinics->stations = [1, 2];
        $result = $clinics->getClinics(false);

        static::assertObjectHasAttribute('Total', $result);
        static::assertObjectHasAttribute('ClinicList', $result);
        static::assertEquals(count($result->ClinicList), 1);
        static::assertObjectHasAttribute('id', $result->ClinicList[0]);
        static::assertEquals($result->ClinicList[0]->stations[0]->Id, '1');
    }

    /**
     * @throws RequiredFieldIsNotSet
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testFind(): void
    {
        $clinics = new Clinics($this->client);
        $clinic = $this->getDefaultClinic();
        $result = $clinics->find($clinic->id);
        static::assertObjectHasAttribute('id', $result);
        static::assertEquals($result->id, $clinic->id);
    }

    /**
     * @throws RequiredFieldIsNotSet
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testFindByAlias(): void
    {
        $clinics = new Clinics($this->client);
        $clinic = $this->getDefaultClinic();
        $result = $clinics->findByAlias($clinic->rewriteName);
        static::assertObjectHasAttribute('id', $result);
        static::assertEquals($result->id, $clinic->id);
    }

    /**
     * @throws RequiredFieldIsNotSet
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetReviews(): void
    {
        $clinics = new Clinics($this->client);
        $clinic = $this->getDefaultClinic();
        $result = $clinics->getReviews($clinic->id);
        foreach ($result as $review) {
            static::assertObjectHasAttribute('Id', $review);
            static::assertObjectHasAttribute('Client', $review);
            static::assertObjectHasAttribute('RatingQlf', $review);
            static::assertObjectHasAttribute('RatingAtt', $review);
            static::assertObjectHasAttribute('RatingRoom', $review);
            static::assertObjectHasAttribute('Text', $review);
            static::assertObjectHasAttribute('Date', $review);
            static::assertObjectHasAttribute('ClinicId', $review);
            static::assertObjectHasAttribute('DoctorId', $review);
            static::assertObjectHasAttribute('Answer', $review);
            static::assertObjectHasAttribute('WaitingTime', $review);
            static::assertObjectHasAttribute('RatingDoctor', $review);
            static::assertObjectHasAttribute('RatingClinic', $review);
            static::assertObjectHasAttribute('TagClinicLocation', $review);
            static::assertObjectHasAttribute('TagClinicService', $review);
            static::assertObjectHasAttribute('TagClinicCost', $review);
            static::assertObjectHasAttribute('TagClinicRecommend', $review);
            static::assertObjectHasAttribute('TagDoctorAttention', $review);
            static::assertObjectHasAttribute('TagDoctorExplain', $review);
            static::assertObjectHasAttribute('TagDoctorQuality', $review);
            static::assertObjectHasAttribute('TagDoctorRecommend', $review);
            static::assertObjectHasAttribute('TagDoctorSatisfied', $review);
            static::assertObjectHasAttribute('ReceptionDate', $review);
        }
    }

    /**
     * @throws MethodIsNotSet
     * @throws RequiredFieldIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testCount(): void
    {
        $clinics = new Clinics($this->client);
        $clinics->city = 1;
        $clinics->type = [1];
        $result = $clinics->clinicCount();
        static::assertObjectHasAttribute('Total', $result);
        static::assertObjectHasAttribute('ClinicSelected', $result);
        static::assertIsNumeric($result->Total);
        static::assertIsNumeric($result->ClinicSelected);
    }

    /**
     * @throws RequiredFieldIsNotSet
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetClinicImages(): void
    {
        $clinics = new Clinics($this->client);
        $clinic = $this->getDefaultClinic();
        $result = $clinics->getClinicImages($clinic->id);
        foreach ($result as $item) {
            static::assertObjectHasAttribute('url', $item);
            static::assertObjectHasAttribute('description', $item);
        }
    }

    /**
     * Get first clinic
     *
     * @return Clinic
     * @throws RequiredFieldIsNotSet
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    protected function getDefaultClinic() : Clinic
    {
        $clinics = new Clinics($this->client);
        if (null === $this->clinic) {
            $clinics->start = 0;
            $clinics->count = 1;
            $clinics->city = 1;
            $this->clinic = $clinics->getClinics()[0];
        }
        return $this->clinic;
    }
}

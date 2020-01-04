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

    // /**
    //  * @throws RequiredFieldIsNotSet
    //  * @throws MethodIsNotSet
    //  * @throws ResponseError
    //  * @throws Unauthorized
    //  */
    // public function testGetReviews(): void
    // {
    //     $clinics = new Clinics($this->client);
    //     $clinic = $this->getDefaultClinic();
    //     $result = $clinics->getReviews($clinic['Id']);
    //     foreach ($result as $review) {
    //         $this->assertArrayHasKey('Id', $review);
    //         $this->assertArrayHasKey('Client', $review);
    //         $this->assertArrayHasKey('RatingQlf', $review);
    //         $this->assertArrayHasKey('RatingAtt', $review);
    //         $this->assertArrayHasKey('RatingRoom', $review);
    //         $this->assertArrayHasKey('Text', $review);
    //         $this->assertArrayHasKey('Date', $review);
    //         $this->assertArrayHasKey('DoctorId', $review);
    //         $this->assertArrayHasKey('ClinicId', $review);
    //         $this->assertArrayHasKey('Answer', $review);
    //         $this->assertArrayHasKey('WaitingTime', $review);
    //         $this->assertArrayHasKey('RatingDoctor', $review);
    //         $this->assertArrayHasKey('RatingClinic', $review);
    //         $this->assertArrayHasKey('TagClinicLocation', $review);
    //         $this->assertArrayHasKey('TagClinicService', $review);
    //         $this->assertArrayHasKey('TagClinicCost', $review);
    //         $this->assertArrayHasKey('TagClinicRecommend', $review);
    //         $this->assertArrayHasKey('TagDoctorAttention', $review);
    //         $this->assertArrayHasKey('TagDoctorExplain', $review);
    //         $this->assertArrayHasKey('TagDoctorQuality', $review);
    //         $this->assertArrayHasKey('TagDoctorRecommend', $review);
    //     }
    // }

    // /**
    //  */
    // public function testCount(): void
    // {
    //     $clinics = new Clinics($this->client);
    //     $result = $clinics->count(1);
    //     static::assertArrayHasKey('Total', $result);
    //     static::assertArrayHasKey('ClinicSelected', $result);
    //     static::assertIsNumeric($result['Total']);
    //     static::assertIsNumeric($result['ClinicSelected']);
    // }

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

    // /**
    //  * @throws MethodIsNotSet
    //  * @throws ResponseError
    //  * @throws Unauthorized
    //  */
    // public function testGetDiagnostics(): void
    // {
    //     $clinics = new Clinics($this->client);
    //     $diagnostics = $clinics->getDiagnostics();
    //     $this->assertTrue(count($diagnostics) > 0);
    //     foreach ($diagnostics as $diagnostic) {
    //         $this->assertArrayHasKey('Name', $diagnostic);
    //         $this->assertArrayHasKey('Alias', $diagnostic);
    //         $this->assertArrayHasKey('SubDiagnosticList', $diagnostic);
    //     }
    // }

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

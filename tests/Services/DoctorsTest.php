<?php

namespace Pecherskiy\DocDoc\Tests\Services;

use Pecherskiy\DocDoc\Entities\Doctor;
use Pecherskiy\DocDoc\Exceptions\CityNumberIncorrect;
use Pecherskiy\DocDoc\Exceptions\MaximumCount;
use Pecherskiy\DocDoc\Exceptions\MethodIsNotSet;
use Pecherskiy\DocDoc\Exceptions\RequiredFieldIsNotSet;
use Pecherskiy\DocDoc\Exceptions\ResponseError;
use Pecherskiy\DocDoc\Exceptions\Unauthorized;

use Pecherskiy\DocDoc\Requests\Doctors;

use function count;

class DoctorsTest extends AbstractCategoryTest
{
    /**
     * @var array
     */
    protected $doctor;

    /**
     * @var array
     */
    protected $specialities;

    /**
     * @throws CityNumberIncorrect
     * @throws MaximumCount
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     * @throws RequiredFieldIsNotSet
     */
    public function testAllMaxCount(): void
    {
        $this->expectException(MaximumCount::class);
        $doctors = new Doctors($this->client);
        $doctors->city = 1;
        $doctors->count = 501;
        $doctors->all();
    }

    /**
     * @throws CityNumberIncorrect
     * @throws MaximumCount
     * @throws MethodIsNotSet
     * @throws RequiredFieldIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testAll(): void
    {
        $doctors = new Doctors($this->client);
        $doctors->city = 1;
        $doctors->count = 10;
        $result = $doctors->all();
        static::assertCount(10, $result->DoctorList);
        foreach ($result->DoctorList as $doctor) {
            static::assertObjectHasAttribute('id', $doctor);
        }
    }

    /**
     * @throws MethodIsNotSet
     * @throws RequiredFieldIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetDoctors(): void
    {
        $doctors = new Doctors($this->client);
        $doctors->city = 1;
        $doctors->stations = [1, 2];
        $doctors->count = 10;
        $doctors->speciality = $this->getSpecialitiesList()[0]->Id;
        $result = $doctors->getDoctors(false);

        static::assertObjectHasAttribute('Total', $result);
        static::assertObjectHasAttribute('DoctorList', $result);
        foreach ($result->DoctorList as $doctor) {
            static::assertObjectHasAttribute('id', $doctor);
            static::assertObjectHasAttribute('name', $doctor);
            static::assertObjectHasAttribute('rating', $doctor);
            static::assertObjectHasAttribute('sex', $doctor);
            static::assertObjectHasAttribute('img', $doctor);
            static::assertObjectHasAttribute('addPhoneNumber', $doctor);
            static::assertObjectHasAttribute('category', $doctor);
            static::assertObjectHasAttribute('degree', $doctor);
            static::assertObjectHasAttribute('rank', $doctor);
            static::assertObjectHasAttribute('description', $doctor);
            static::assertObjectHasAttribute('experienceYear', $doctor);
            static::assertObjectHasAttribute('price', $doctor);
            static::assertObjectHasAttribute('specialPrice', $doctor);
            static::assertObjectHasAttribute('departure', $doctor);
            static::assertObjectHasAttribute('clinics', $doctor);
            static::assertObjectHasAttribute('alias', $doctor);
            static::assertObjectHasAttribute('specialities', $doctor);
            static::assertObjectHasAttribute('stations', $doctor);
            static::assertObjectHasAttribute('bookingClinics', $doctor);
            static::assertObjectHasAttribute('isActive', $doctor);
            static::assertObjectHasAttribute('textAbout', $doctor);
            static::assertObjectHasAttribute('internalRating', $doctor);
            static::assertObjectHasAttribute('opinionCount', $doctor);
            static::assertObjectHasAttribute('extra', $doctor);
            static::assertObjectHasAttribute('kidsReception', $doctor);
            static::assertObjectHasAttribute('clinicsInfo', $doctor);
        }
    }

    /**
     * @throws CityNumberIncorrect
     * @throws MaximumCount
     * @throws MethodIsNotSet
     * @throws RequiredFieldIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testFind(): void
    {
        $doctors = new Doctors($this->client);
        $doctor = $this->getDefaultDoctor();
        $result = $doctors->find($doctor->id);
        static::assertEquals($doctor->id, $result->id);
    }

    /**
     * @throws CityNumberIncorrect
     * @throws MaximumCount
     * @throws MethodIsNotSet
     * @throws RequiredFieldIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testFindByAlias(): void
    {
        $doctors = new Doctors($this->client);
        $doctor = $this->getDefaultDoctor();
        $result = $doctors->findByAlias($doctor->alias);
        static::assertEquals($doctor->id, $result->id);
    }

    /**
     * @throws CityNumberIncorrect
     * @throws MaximumCount
     * @throws MethodIsNotSet
     * @throws RequiredFieldIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetReview(): void
    {
        $doctors = new Doctors($this->client);
        $doctor = $this->getDefaultDoctor();
        $result = $doctors->getReviews($doctor->id);
        foreach ($result as $review) {
            static::assertObjectHasAttribute('Id', $review);
            static::assertObjectHasAttribute('Client', $review);
            static::assertObjectHasAttribute('RatingQlf', $review);
            static::assertObjectHasAttribute('RatingAtt', $review);
            static::assertObjectHasAttribute('RatingRoom', $review);
            static::assertObjectHasAttribute('Text', $review);
            static::assertObjectHasAttribute('Date', $review);
            static::assertObjectHasAttribute('DoctorId', $review);
            static::assertObjectHasAttribute('ClinicId', $review);
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
        }
    }

    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetSpecialities(): void
    {
        $doctors = new Doctors($this->client);
        $result = $doctors->getSpecialities(1);
        static::assertTrue(count($result) > 0);
    }

    /**
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    public function testGetServices(): void
    {
        $doctors = new Doctors($this->client);
        $result = $doctors->getServices();
        static::assertTrue(count($result) > 0);
        foreach ($result as $service) {
            static::assertObjectHasAttribute('Id', $service);
            static::assertObjectHasAttribute('Name', $service);
            static::assertObjectHasAttribute('Lft', $service);
            static::assertObjectHasAttribute('Rgt', $service);
            static::assertObjectHasAttribute('Depth', $service);
            static::assertObjectHasAttribute('SectorId', $service);
            static::assertObjectHasAttribute('DiagnosticaId', $service);
        }
    }

    /**
     * @return Doctor
     * @throws CityNumberIncorrect
     * @throws MaximumCount
     * @throws MethodIsNotSet
     * @throws RequiredFieldIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    protected function getDefaultDoctor(): Doctor
    {
        if (null === $this->doctor) {
            $doctors = new Doctors($this->client);
            $doctors->city = 1;
            $doctors->count = 1;
            $this->doctor = $doctors->all()->DoctorList[0];
        }
        return $this->doctor;
    }

    /**
     * @return array
     * @throws MethodIsNotSet
     * @throws ResponseError
     * @throws Unauthorized
     */
    protected function getSpecialitiesList(): array
    {
        if (null === $this->specialities) {
            $doctors = new Doctors($this->client);
            $this->specialities = $doctors->getSpecialities(1);
        }
        return $this->specialities;
    }
}

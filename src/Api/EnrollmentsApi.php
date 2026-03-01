<?php

declare(strict_types=1);

namespace ScormEngineSdk\Api;

use ScormEngineSdk\Constants\ApiEndpoint;
use ScormEngineSdk\Http\ApiHttpClient;
use ScormEngineSdk\Mapper\DtoMapperInterface;
use ScormEngineSdk\Model\Dto\EnrollmentDto;
use ScormEngineSdk\Model\Form\EnrollUserForm;
use ScormEngineSdk\Model\Pagination\PageResult;
use ScormEngineSdk\Model\Query\EnrollmentListQuery;

final readonly class EnrollmentsApi
{
    public function __construct(private ApiHttpClient $httpClient, private DtoMapperInterface $mapper)
    {
    }

    public function enroll(EnrollUserForm $form): EnrollmentDto
    {
        $response = $this->httpClient->postJson(ApiEndpoint::ENROLLMENTS, $form->toArray());
        return $this->mapper->mapEnrollment($response);
    }

    public function listEnrollments(?EnrollmentListQuery $query = null): PageResult
    {
        $query = $query ?? new EnrollmentListQuery();
        $response = $this->httpClient->get(ApiEndpoint::ENROLLMENTS, $query->toArray());

        return $this->mapper->mapPageResult($response, $this->mapper->mapEnrollment(...));
    }
}

<?php

declare(strict_types=1);

namespace ScormEngineSdk\Api;

use ScormEngineSdk\Constants\ApiEndpoint;
use ScormEngineSdk\Constants\StringValue;
use ScormEngineSdk\Http\ApiHttpClient;
use ScormEngineSdk\Mapper\DtoMapperInterface;
use ScormEngineSdk\Model\Dto\AttemptProgressDto;
use ScormEngineSdk\Model\Pagination\PageResult;
use ScormEngineSdk\Model\Query\AttemptListQuery;

final readonly class AttemptsApi
{
    private const PROGRESS_SUFFIX = '/progress';

    public function __construct(private ApiHttpClient $httpClient, private DtoMapperInterface $mapper)
    {
    }

    public function getProgress(string $attemptId): AttemptProgressDto
    {
        $response = $this->httpClient->get($this->attemptProgressPath($attemptId));
        return $this->mapper->mapAttemptProgress($response);
    }

    public function listAttempts(?AttemptListQuery $query = null): PageResult
    {
        $query = $query ?? new AttemptListQuery();
        $response = $this->httpClient->get(ApiEndpoint::ATTEMPTS, $query->toArray());

        return $this->mapper->mapPageResult($response, $this->mapper->mapAttempt(...));
    }

    private function attemptProgressPath(string $attemptId): string
    {
        return ApiEndpoint::ATTEMPTS
            . StringValue::PATH_SEPARATOR
            . rawurlencode($attemptId)
            . self::PROGRESS_SUFFIX;
    }
}

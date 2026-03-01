<?php

declare(strict_types=1);

namespace ScormEngineSdk\Api;

use ScormEngineSdk\Constants\ApiEndpoint;
use ScormEngineSdk\Constants\StringValue;
use ScormEngineSdk\Http\ApiHttpClient;
use ScormEngineSdk\Mapper\DtoMapperInterface;
use ScormEngineSdk\Model\Dto\UserDto;
use ScormEngineSdk\Model\Form\CreateUserForm;
use ScormEngineSdk\Model\Pagination\PageResult;
use ScormEngineSdk\Model\Query\UserListQuery;

final readonly class UsersApi
{
    public function __construct(private ApiHttpClient $httpClient, private DtoMapperInterface $mapper)
    {
    }

    public function createUser(CreateUserForm $form): UserDto
    {
        $response = $this->httpClient->postJson(ApiEndpoint::USERS, $form->toArray());
        return $this->mapper->mapUser($response);
    }

    public function getUser(string $userId): UserDto
    {
        $response = $this->httpClient->get($this->userPath($userId));
        return $this->mapper->mapUser($response);
    }

    public function listUsers(?UserListQuery $query = null): PageResult
    {
        $query = $query ?? new UserListQuery();
        $response = $this->httpClient->get(ApiEndpoint::USERS, $query->toArray());

        return $this->mapper->mapPageResult($response, $this->mapper->mapUser(...));
    }

    private function userPath(string $userId): string
    {
        return ApiEndpoint::USERS . StringValue::PATH_SEPARATOR . rawurlencode($userId);
    }
}

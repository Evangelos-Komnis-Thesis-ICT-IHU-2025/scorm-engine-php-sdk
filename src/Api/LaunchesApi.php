<?php

declare(strict_types=1);

namespace ScormEngineSdk\Api;

use ScormEngineSdk\Auth\LaunchTokenAuthStrategy;
use ScormEngineSdk\Constants\ApiEndpoint;
use ScormEngineSdk\Constants\StringValue;
use ScormEngineSdk\Http\ApiHttpClient;
use ScormEngineSdk\Mapper\DtoMapperInterface;
use ScormEngineSdk\Model\Dto\LaunchContextDto;
use ScormEngineSdk\Model\Dto\LaunchCreatedDto;
use ScormEngineSdk\Model\Form\CreateLaunchForm;

final readonly class LaunchesApi
{
    private const TERMINATE_SUFFIX = '/terminate';

    public function __construct(private ApiHttpClient $httpClient, private DtoMapperInterface $mapper)
    {
    }

    public function createLaunch(CreateLaunchForm $form): LaunchCreatedDto
    {
        $response = $this->httpClient->postJson(ApiEndpoint::LAUNCHES, $form->toArray());
        return $this->mapper->mapLaunchCreated($response);
    }

    public function getLaunchContext(string $launchId, string $launchToken): LaunchContextDto
    {
        $response = $this->httpClient->get(
            path: $this->launchPath($launchId),
            auth: new LaunchTokenAuthStrategy($launchToken)
        );

        return $this->mapper->mapLaunchContext($response);
    }

    public function terminateLaunch(string $launchId, string $launchToken): void
    {
        $this->httpClient->postNoBody(
            path: $this->terminateLaunchPath($launchId),
            auth: new LaunchTokenAuthStrategy($launchToken)
        );
    }

    private function launchPath(string $launchId): string
    {
        return ApiEndpoint::LAUNCHES . StringValue::PATH_SEPARATOR . rawurlencode($launchId);
    }

    private function terminateLaunchPath(string $launchId): string
    {
        return $this->launchPath($launchId) . self::TERMINATE_SUFFIX;
    }
}

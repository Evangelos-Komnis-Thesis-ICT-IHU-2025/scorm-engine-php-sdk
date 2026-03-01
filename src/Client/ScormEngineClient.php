<?php

declare(strict_types=1);

namespace ScormEngineSdk\Client;

use ScormEngineSdk\Api\AttemptsApi;
use ScormEngineSdk\Api\CoursesApi;
use ScormEngineSdk\Api\EnrollmentsApi;
use ScormEngineSdk\Api\LaunchesApi;
use ScormEngineSdk\Api\UsersApi;

final class ScormEngineClient
{
    private readonly CoursesApi $coursesApi;
    private readonly UsersApi $usersApi;
    private readonly EnrollmentsApi $enrollmentsApi;
    private readonly LaunchesApi $launchesApi;
    private readonly AttemptsApi $attemptsApi;

    public function __construct(
        CoursesApi $coursesApi,
        UsersApi $usersApi,
        EnrollmentsApi $enrollmentsApi,
        LaunchesApi $launchesApi,
        AttemptsApi $attemptsApi
    ) {
        $this->coursesApi = $coursesApi;
        $this->usersApi = $usersApi;
        $this->enrollmentsApi = $enrollmentsApi;
        $this->launchesApi = $launchesApi;
        $this->attemptsApi = $attemptsApi;
    }

    public function courses(): CoursesApi
    {
        return $this->coursesApi;
    }

    public function users(): UsersApi
    {
        return $this->usersApi;
    }

    public function enrollments(): EnrollmentsApi
    {
        return $this->enrollmentsApi;
    }

    public function launches(): LaunchesApi
    {
        return $this->launchesApi;
    }

    public function attempts(): AttemptsApi
    {
        return $this->attemptsApi;
    }
}

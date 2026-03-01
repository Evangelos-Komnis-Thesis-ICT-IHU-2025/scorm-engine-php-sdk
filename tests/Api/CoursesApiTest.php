<?php

declare(strict_types=1);

namespace ScormEngineSdk\Tests\Api;

use GuzzleHttp\Psr7\HttpFactory;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use ScormEngineSdk\Auth\BearerTokenAuthStrategy;
use ScormEngineSdk\Client\ScormEngineClientFactory;
use ScormEngineSdk\Configuration\Configuration;
use ScormEngineSdk\Tests\Support\FakeTransport;

final class CoursesApiTest extends TestCase
{
    public function testImportCourseBuildsMultipartRequest(): void
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'scorm-test-');
        self::assertNotFalse($tempFile);
        file_put_contents($tempFile, 'zip-content');

        $transport = new FakeTransport([
            new Response(201, ['Content-Type' => 'application/json'], json_encode([
                'id' => 'course-1',
                'title' => 'Course 1',
            ], JSON_THROW_ON_ERROR)),
        ]);

        $config = new Configuration(
            baseUrl: 'http://localhost:8080/api/v1',
            defaultAuthStrategy: new BearerTokenAuthStrategy('admin-token')
        );

        $factory = new HttpFactory();
        $client = (new ScormEngineClientFactory())->createDefault($config, $transport, $factory, $factory);

        $course = $client->courses()->importCourse($tempFile, 'CODE1', 'v1', 'RuntimeBasicCalls_SCORM12.zip');

        self::assertSame('course-1', $course->getId());

        $request = $transport->lastRequest();
        self::assertNotNull($request);
        self::assertSame('POST', $request->getMethod());
        self::assertSame('/api/v1/courses/import', $request->getUri()->getPath());
        self::assertStringStartsWith('multipart/form-data; boundary=', $request->getHeaderLine('Content-Type'));
        self::assertSame('Bearer admin-token', $request->getHeaderLine('Authorization'));

        $body = (string) $request->getBody();
        self::assertStringContainsString('name="file"', $body);
        self::assertStringContainsString('filename="RuntimeBasicCalls_SCORM12.zip"', $body);
        self::assertStringContainsString('name="code"', $body);
        self::assertStringContainsString('CODE1', $body);
        self::assertStringContainsString('name="versionLabel"', $body);
        self::assertStringContainsString('v1', $body);

        unlink($tempFile);
    }
}

<?php

declare(strict_types=1);

namespace ScormEngineSdk\Tests\Mapper;

use PHPUnit\Framework\TestCase;
use ScormEngineSdk\Mapper\DtoMapper;

final class DtoMapperTest extends TestCase
{
    public function testMapsPageResultWithCourseDtos(): void
    {
        $mapper = new DtoMapper();

        $page = $mapper->mapPageResult([
            'items' => [
                ['id' => 'c1', 'title' => 'Course 1', 'standard' => 'SCORM_12'],
                ['id' => 'c2', 'title' => 'Course 2', 'standard' => 'SCORM_2004'],
            ],
            'page' => 1,
            'size' => 2,
            'totalItems' => 4,
            'totalPages' => 2,
        ], $mapper->mapCourse(...));

        self::assertCount(2, $page->getItems());
        self::assertSame('c1', $page->getItems()[0]->getId());
        self::assertSame('Course 2', $page->getItems()[1]->getTitle());
        self::assertSame(1, $page->getPage());
        self::assertSame(4, $page->getTotalItems());
    }
}

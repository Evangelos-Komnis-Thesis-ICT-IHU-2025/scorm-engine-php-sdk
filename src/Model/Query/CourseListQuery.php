<?php

declare(strict_types=1);

namespace ScormEngineSdk\Model\Query;

use ScormEngineSdk\Constants\FieldKey;
use ScormEngineSdk\Constants\QueryDefaults;
use ScormEngineSdk\Constants\StringValue;

final class CourseListQuery extends BaseQuery
{
    public function __construct(
        int $page = 0,
        int $size = 20,
        string $sort = QueryDefaults::SORT_CREATED_AT_DESC,
        private ?string $search = null,
        private ?string $standard = null
    ) {
        parent::__construct($page, $size, $sort);
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }

    public function setSearch(?string $search): void
    {
        $this->search = $search;
    }

    public function getStandard(): ?string
    {
        return $this->standard;
    }

    public function setStandard(?string $standard): void
    {
        $this->standard = $standard;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return array_filter(
            parent::toArray() + [
                FieldKey::SEARCH => $this->getSearch(),
                FieldKey::STANDARD => $this->getStandard(),
            ],
            fn (mixed $value): bool => $value !== null && $value !== StringValue::EMPTY
        );
    }
}

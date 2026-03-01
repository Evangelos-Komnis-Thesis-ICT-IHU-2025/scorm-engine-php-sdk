<?php

declare(strict_types=1);

namespace ScormEngineSdk\Model\Query;

use ScormEngineSdk\Constants\FieldKey;
use ScormEngineSdk\Constants\QueryDefaults;

class BaseQuery
{
    public function __construct(
        private int $page = 0,
        private int $size = 20,
        private string $sort = QueryDefaults::SORT_CREATED_AT_DESC
    ) {
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function setPage(int $page): void
    {
        $this->page = $page;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function setSize(int $size): void
    {
        $this->size = $size;
    }

    public function getSort(): string
    {
        return $this->sort;
    }

    public function setSort(string $sort): void
    {
        $this->sort = $sort;
    }

    /**
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            FieldKey::PAGE => $this->getPage(),
            FieldKey::SIZE => $this->getSize(),
            FieldKey::SORT => $this->getSort(),
        ];
    }
}

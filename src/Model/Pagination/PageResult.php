<?php

declare(strict_types=1);

namespace ScormEngineSdk\Model\Pagination;

/**
 * @template T
 */
final class PageResult
{
    /**
     * @param array<int,T> $items
     */
    public function __construct(
        private array $items,
        private int $page,
        private int $size,
        private int $totalItems,
        private int $totalPages
    ) {
    }

    /**
     * @return array<int,T>
     */
    public function getItems(): array
    {
        return $this->items;
    }

    /**
     * @param array<int,T> $items
     */
    public function setItems(array $items): void
    {
        $this->items = $items;
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

    public function getTotalItems(): int
    {
        return $this->totalItems;
    }

    public function setTotalItems(int $totalItems): void
    {
        $this->totalItems = $totalItems;
    }

    public function getTotalPages(): int
    {
        return $this->totalPages;
    }

    public function setTotalPages(int $totalPages): void
    {
        $this->totalPages = $totalPages;
    }
}

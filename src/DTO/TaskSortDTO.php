<?php

declare(strict_types=1);

namespace App\DTO;

class TaskSortDTO
{
    /**
     * @var array<TaskSortItemDTO> $sortItems
     */
    private array $sortItems;

    public function __construct(TaskSortItemDTO ...$sortItems) {
        $this->sortItems = $sortItems;
    }

    /**
     * @return array<TaskSortItemDTO>
     */
    public function getSortItems(): array
    {
        return $this->sortItems;
    }
}
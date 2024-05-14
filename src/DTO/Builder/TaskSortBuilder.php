<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\TaskSortDTO;
use App\DTO\TaskSortItemDTO;
use App\Enum\SortTypeEnum;

class TaskSortBuilder
{
    /**
     * @var array<TaskSortItemDTO> $sortItems
     */
    private array $sortItems = [];

    public function addSortItem(string $field, SortTypeEnum $order = SortTypeEnum::ASC): self
    {
        $this->sortItems[] = new TaskSortItemDTO($field, $order);

        return $this;
    }

    public function build(): TaskSortDTO
    {
        $dto = new TaskSortDTO(...$this->sortItems);

        $this->reset();

        return $dto;
    }

    public function reset(): self
    {
        $this->sortItems = [];

        return $this;
    }

    public function fromArray(array $data): self
    {
        foreach ($data['sort'] ?? [] as $item) {
            $this->sortItems[] = new TaskSortItemDTO($item['field'], SortTypeEnum::tryFrom($item['order']));
        }

        return $this;
    }
}
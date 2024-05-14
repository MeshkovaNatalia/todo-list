<?php

declare(strict_types=1);

namespace App\DTO;

use App\Enum\SortTypeEnum;

class TaskSortItemDTO
{
    /**
     * It would be ideal to limit the list of field names to an enum,
     * because this option allows you to transfer anything
     */
    public function __construct(
        private string $field,
        private SortTypeEnum $type,
    ) {
    }

    public function getField(): string
    {
        return $this->field;
    }

    public function getType(): SortTypeEnum
    {
        return $this->type;
    }
}
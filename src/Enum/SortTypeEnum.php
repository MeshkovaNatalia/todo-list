<?php

declare(strict_types=1);

namespace App\Enum;

enum SortTypeEnum: string
{
    case ASC = 'asc';
    case DESC = 'desc';
}
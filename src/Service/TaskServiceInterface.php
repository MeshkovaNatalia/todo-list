<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\TaskFilterDTO;
use App\DTO\TaskSortDTO;
use App\Entity\Task;

interface TaskServiceInterface
{
    public function canMarkAsCompleted(Task $task): bool;

    public function markAsCompleted(Task $task): void;

    public function isTaskCompleted(Task $task): bool;
}
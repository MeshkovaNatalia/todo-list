<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Task;
use App\Formatter\TaskFormatterInterface;

class TaskService implements TaskServiceInterface
{
    public function markAsCompleted(Task $task): void
    {
        $task->setStatus(Task::STATUS_COMPLETED);
    }

    public function canMarkAsCompleted(Task $task): bool
    {
        foreach ($task->getSubTasks() as $subTask) {
            if ($subTask->getStatus() === Task::STATUS_TODO) {
                return false;
            }
        }

        return true;
    }
}
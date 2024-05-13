<?php

declare(strict_types=1);

namespace App\Formatter;

use App\Entity\Task;
use App\Formatter\DTO\FormattedTasksDTO;

class TaskFormatter implements TaskFormatterInterface
{
    public function formatAsTree(array $tasks): array
    {
        return $this->formatTaskAsTree($tasks, null);
    }

    private function formatTaskAsTree(array $tasks, int $parentId = null): array
    {
        $tree = [];

        /** @var Task $task */
        foreach ($tasks as $task) {
            if ($parentId === $task->getParent()?->getId()) {
                $subTasks = $this->formatTaskAsTree($tasks, $task->getId());

                $formattedTask = new FormattedTasksDTO(
                    $task->getId(),
                    $task->getTitle(),
                    $task->getStatus(),
                    $task->getParent()?->getId(),
                    $subTasks
                );

                $tree[] = $formattedTask;
            }
        }

        return $tree;
    }
}

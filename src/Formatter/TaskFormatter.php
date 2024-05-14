<?php

declare(strict_types=1);

namespace App\Formatter;

use App\Entity\Task;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class TaskFormatter implements TaskFormatterInterface
{
    public function formatAsTree(array $tasks): array
    {
        return $this->formatTaskAsTree($tasks, null)->toArray();
    }

    private function formatTaskAsTree(array $tasks, int $parentId = null): Collection
    {
        $tree = new ArrayCollection();

        /** @var Task $task */
        foreach ($tasks as $task) {
            if ($parentId === $task->getParent()?->getId()) {
                $subTasks = $this->formatTaskAsTree($tasks, $task->getId());

                $task->setSubTasks($subTasks);

                $tree->add($task);
            }
        }

        return $tree;
    }
}

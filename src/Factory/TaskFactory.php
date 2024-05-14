<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Task;
use App\Entity\User;

class TaskFactory implements TaskFactoryInterface
{
    public function createNew(
        string $title,
        string $description,
        int $priority,
        User $owner,
        ?Task $parent = null,
    ): Task {
        return $this->create(
            $title,
            $description,
            $priority,
            false,
            null,
            $owner,
            $parent,
        );
    }

    public function create(
        string $title,
        string $description,
        int $priority,
        bool $status,
        ?\DateTimeImmutable $completedAt,
        User $owner,
        ?Task $parent = null,
    ): Task {
        $task = new Task();
        $task->setTitle($title);
        $task->setDescription($description);
        $task->setPriority($priority);
        $task->setStatus($status);
        $task->setCompletedAt($completedAt);
        $task->setOwner($owner);
        $task->setParent($parent);

        return $task;
    }
}
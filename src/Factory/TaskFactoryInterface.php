<?php

declare(strict_types=1);

namespace App\Factory;

use App\Entity\Task;
use App\Entity\User;

interface TaskFactoryInterface
{
    public function createNew(
        string $title,
        string $description,
        int $priority,
        User $owner,
        ?Task $parent = null,
    ): Task;

    public function create(
        string $title,
        string $description,
        int $priority,
        bool $status,
        ?\DateTimeImmutable $completedAt,
        User $owner,
        ?Task $parent = null,
    ): Task;
}
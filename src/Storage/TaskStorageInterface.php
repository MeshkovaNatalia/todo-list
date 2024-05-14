<?php

declare(strict_types=1);

namespace App\Storage;

use App\DTO\TaskFilterDTO;
use App\DTO\TaskSortDTO;
use App\Entity\Task;
use App\Entity\User;

interface TaskStorageInterface
{
    public function save(Task $task): void;

    public function remove(Task $task): void;

    public function get(int $id): ?Task;

    public function has(int $id): bool;

    public function getAllForUser(User $user): array;

    public function getAllForUserFiltered(User $user, TaskFilterDTO $filter, TaskSortDTO $sort): array;
}
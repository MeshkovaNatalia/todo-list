<?php

declare(strict_types=1);

namespace App\Formatter;

use App\Entity\Task;

interface TaskFormatterInterface
{
    /**
     * @param array<Task> $tasks
     *
     * @return array<FormattedTaskDTO>
     */
    public function formatAsTree(array $tasks): array;
}
<?php

declare(strict_types=1);

namespace App\DTO;

class TaskFilterDTO
{
    public function __construct(
        private ?bool $status = null,
        private ?int $priority = null,
        private ?string $search = null,
    ) {
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function getPriority(): ?int
    {
        return $this->priority;
    }

    public function getSearch(): ?string
    {
        return $this->search;
    }
}
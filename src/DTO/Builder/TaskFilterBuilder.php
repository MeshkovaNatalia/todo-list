<?php

declare(strict_types=1);

namespace App\DTO\Builder;

use App\DTO\TaskFilterDTO;

class TaskFilterBuilder
{
    private ?bool $status = null;
    private ?int $priority = null;
    private ?string $search = null;

    public function setStatus(?bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function setPriority(?int $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function setSearch(?string $search): self
    {
        $this->search = $search;

        return $this;
    }

    public function build(): TaskFilterDTO
    {
        $dto = new TaskFilterDTO(
            $this->status,
            $this->priority,
            $this->search,
        );

        $this->reset();

        return $dto;
    }

    public function reset(): self
    {
        $this->status = null;
        $this->priority = null;
        $this->search = null;

        return $this;
    }

    public function fromArray(array $data): self
    {
        // It is possible that the names of the keys should be put into constants
        $this->status = $data['status'] ?? null;
        $this->priority = $data['priority'] ?? null;
        $this->search = $data['search'] ?? null;

        return $this;
    }
}
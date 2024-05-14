<?php

declare(strict_types=1);

namespace App\Formatter\DTO;

class FormattedTasksDTO implements \JsonSerializable
{
    /**
     * @param array<FormattedTaskDTO> $children
     */
    public function __construct(
        private int $id,
        private string $title,
        private ?string $description,
        private bool $status,
        private int $priority,
        private ?int $parentId,
        private array $children = []
    ) {
    }

    public function jsonSerialize(): array
    {
        // It is possible that the names of the keys should be put into constants
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'status' => $this->status,
            'priority' => $this->priority,
            'parentId' => $this->parentId,
            'children' => $this->children,
        ];
    }
}
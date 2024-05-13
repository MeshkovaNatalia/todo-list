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
        private bool $status,
        private ?int $parentId,
        private array $children = []
    ) {
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'status' => $this->status,
            'parentId' => $this->parentId,
            'children' => $this->children,
        ];
    }
}
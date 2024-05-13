<?php

declare(strict_types=1);

namespace App\Storage;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class TaskStorage implements TaskStorageInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function save(Task $task): void
    {
        $this->entityManager->persist($task);
        $this->entityManager->flush();
    }

    public function remove(Task $task): void
    {
        $this->entityManager->remove($task);
        $this->entityManager->flush();
    }

    public function get(int $id): ?Task
    {
        return $this->entityManager->getRepository(Task::class)->find($id);
    }

    public function has(int $id): bool
    {
        return null !== $this->entityManager->getRepository(Task::class)->find($id);
    }

    public function getAllForUser(User $user): array
    {
        return $this->entityManager->getRepository(Task::class)->findBy(['owner' => $user]);
    }
}
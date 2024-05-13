<?php

declare(strict_types=1);

namespace App\Controller;

use App\Storage\TaskStorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class RemoveTaskController extends AbstractController
{
    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker,
        private TaskStorageInterface $taskStorage,
    ) {
    }

    #[Route('/tasks/{taskId}', methods: ['DELETE'])]
    public function __invoke(Request $request, int $taskId): JsonResponse
    {
        $task = $this->taskStorage->get($taskId);

        if (null === $task) {
            return $this->json(['error' => 'Task not found'], 404);
        }

        if (false === $this->authorizationChecker->isGranted('owner', $task)) {
            return $this->json(['error' => 'Access denied'], 403);
        }

        $this->taskStorage->remove($task);

        return $this->json('Task removed successfully', 201);
    }
}
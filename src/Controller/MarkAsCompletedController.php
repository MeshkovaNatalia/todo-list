<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\TaskServiceInterface;
use App\Storage\TaskStorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class MarkAsCompletedController extends AbstractController
{
    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker,
        private TaskStorageInterface $taskStorage,
        private TaskServiceInterface $taskService,
    ) {
    }

    #[Route('/tasks/{taskId}/mark-as-completed', methods: ['POST'])]
    public function __invoke(Request $request, int $taskId): JsonResponse
    {
        $task = $this->taskStorage->get($taskId);

        if (null === $task) {
            return $this->json(['error' => 'Task not found'], 404);
        }

        if (false === $this->authorizationChecker->isGranted('owner', $task)) {
            return $this->json(['error' => 'Access denied'], 403);
        }

        if (false === $this->taskService->canMarkAsCompleted($task)) {
            return $this->json(['error' => 'Task cannot be marked as completed'], 400);
        }

        $this->taskService->markAsCompleted($task);
        $this->taskStorage->save($task);

        return $this->json($task, 201);
    }
}
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
use OpenApi\Annotations as OA;

class RemoveTaskController extends AbstractController
{
    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker,
        private TaskStorageInterface $taskStorage,
        private TaskServiceInterface $taskService,
    ) {
    }

    #[Route('/tasks/{taskId}', methods: ['DELETE'])]
    /**
     * @OA\Delete(
     *     path="/tasks/{taskId}",
     *     summary="Delete a task",
     *     description="Delete a task by its ID",
     *     @OA\Parameter(
     *         name="taskId",
     *         in="path",
     *         description="ID of the task to delete",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Task removed successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Task is completed or other error",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Task is completed")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Access denied",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Access denied")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Task not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="error", type="string", example="Task not found")
     *         )
     *     )
     * )
     */
    public function __invoke(Request $request, int $taskId): JsonResponse
    {
        $task = $this->taskStorage->get($taskId);

        if (null === $task) {
            return $this->json(['error' => 'Task not found'], 404);
        }

        if (false === $this->authorizationChecker->isGranted('owner', $task)) {
            return $this->json(['error' => 'Access denied'], 403);
        }

        if (true === $this->taskService->isTaskCompleted($task)) {
            return $this->json(['error' => 'Task is completed'], 400);
        }

        $this->taskStorage->remove($task);

        return $this->json('Task removed successfully', 201);
    }
}
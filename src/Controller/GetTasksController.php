<?php

declare(strict_types=1);

namespace App\Controller;

use App\Formatter\TaskFormatterInterface;
use App\Storage\TaskStorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class GetTasksController extends AbstractController
{
    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker,
        private TaskStorageInterface $taskStorage,
        private TaskFormatterInterface $taskFormatter,
    ) {
    }

    #[Route('/tasks', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $tasks = $this->taskStorage->getAllForUser($this->getUser());

        $tasks = $this->taskFormatter->formatAsTree($tasks);

        return $this->json($tasks, 201);
    }
}
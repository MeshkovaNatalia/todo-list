<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\TaskFormType;
use App\Storage\TaskStorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UpdateTaskController extends AbstractController
{
    public function __construct(
        private AuthorizationCheckerInterface $authorizationChecker,
        private TaskStorageInterface $taskStorage,
    ) {
    }

    #[Route('/tasks/{taskId}', methods: ['PATCH'])]
    public function __invoke(Request $request, int $taskId): JsonResponse
    {
        $task = $this->taskStorage->get($taskId);

        if (null === $task) {
            return $this->json(['error' => 'Task not found'], 404);
        }

        if (false === $this->authorizationChecker->isGranted('owner', $task)) {
            return $this->json(['error' => 'Access denied'], 403);
        }

        $form = $this->createForm(TaskFormType::class);
        $form->submit($request->request->all());

        if (false === $form->isValid()) {
            return $this->json($form->getErrors(true), 400);
        }

        $task = $form->getData();
        $this->taskStorage->save($task);

        return $this->json($task, 201);
    }
}
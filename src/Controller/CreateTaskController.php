<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\TaskFormType;
use App\Storage\TaskStorageInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CreateTaskController extends AbstractController
{
    public function __construct(
        private TaskStorageInterface $taskStorage,
    ) {
    }

    #[Route('/tasks', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
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
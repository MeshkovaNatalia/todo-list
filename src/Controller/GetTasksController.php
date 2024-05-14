<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Builder\TaskFilterBuilder;
use App\DTO\Builder\TaskSortBuilder;
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
        private TaskFilterBuilder $taskFilterBuilder,
        private TaskSortBuilder $taskSortBuilder,
    ) {
    }

    #[Route('/tasks', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $filterParams = \json_decode($request->query->get('filter'), true) ?? [];
        $sortParams =  \json_decode($request->query->get('sort'), true) ?? [];

        // It should be validation here

        $filter = $this->taskFilterBuilder->fromArray($filterParams)->build();
        $sort = $this->taskSortBuilder->fromArray($sortParams)->build();

        $tasks = $this->taskStorage->getAllForUserFiltered($this->getUser(), $filter, $sort);
        $tasks = $this->taskFormatter->formatAsTree($tasks);

        return $this->json($tasks, 201);
    }
}
<?php

declare(strict_types=1);

namespace App\Repository;

use App\DTO\TaskFilterDTO;
use App\DTO\TaskSortDTO;
use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Task>
 */
class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    // Maybe it should be broken into several, but I made one to speed up the task
    public function findByFilterAndSort(int $userId, TaskFilterDTO $filter, TaskSortDTO $sort): array
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.owner = :userId')
            ->setParameter('userId', $userId);

        if (null !== $filter->getStatus()) {
            $qb->andWhere('t.status = :status')
                ->setParameter('status', $filter->getStatus());
        }

        if (null !== $filter->getPriority()) {
            $qb->andWhere('t.priority = :priority')
                ->setParameter('priority', $filter->getPriority());
        }

        if (null !== $filter->getSearch()) {
            $qb->andWhere('t.title LIKE :search OR t.description LIKE :search')
                ->setParameter('search', '%' . $filter->getSearch() . '%');
        }

        foreach ($sort->getSortItems() as $item) {
            $qb->addOrderBy('t.' . $item->getField(), $item->getType()->value);
        }

        return $qb->getQuery()->getResult();
    }
}

<?php

declare(strict_types=1);

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Task;
use App\Entity\User;

class TaskFixture extends Fixture implements OrderedFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 1; $i <= 3; $i++) {
            $user = $users[\array_rand($users)];

            $task = new Task();
            $task->setTitle('Task Level 1 - ' . $i);
            $task->setDescription('Description for Task Level 1 - ' . $i);
            $task->setOwner($user);
            $task->setPriority(1);
            $manager->persist($task);
            $this->addReference('task-level-1-' . $i, $task);

            // Second level tasks
            for ($j = 1; $j <= 2; $j++) {
                $subTask = new Task();
                $subTask->setTitle('Task Level 2 - ' . $i . '.' . $j);
                $subTask->setDescription('Description for Task Level 2 - ' . $i);
                $subTask->setParent($task);
                $subTask->setOwner($user);
                $subTask->setPriority(1);
                $manager->persist($subTask);
                $this->addReference('task-level-2-' . $i . '-' . $j, $subTask);

                // Third level tasks
                for ($k = 1; $k <= 1; $k++) {
                    $subSubTask = new Task();
                    $subSubTask->setTitle('Task Level 3 - ' . $i . '.' . $j . '.' . $k);
                    $subSubTask->setDescription('Description for Task Level 3 - ' . $i);
                    $subSubTask->setParent($subTask);
                    $subSubTask->setOwner($user);
                    $subSubTask->setPriority(1);
                    $manager->persist($subSubTask);
                    $this->addReference('task-level-3-' . $i . '-' . $j . '-' . $k, $subSubTask);
                }
            }
        }

        $manager->flush();
    }

    public function getOrder(): int
    {
        return 2;
    }
}
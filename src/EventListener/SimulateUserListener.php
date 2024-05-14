<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

#[AutoconfigureTag('kernel.event_listener', ['event' => 'kernel.request'])]
class SimulateUserListener
{
    public function __construct(
        private TokenStorageInterface $tokenStorage,
        private EntityManagerInterface $entityManager,
    ) {
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $user = $this->entityManager->getRepository(User::class)->find(22);

        $newToken = new UsernamePasswordToken($user, 'main', $user->getRoles());

        $this->tokenStorage->setToken($newToken);
    }
}
<?php

declare(strict_types=1);

namespace App\Voter;

use App\Entity\Task;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use App\Entity\User;

class TaskVoter extends Voter
{
    private const OWNER = 'owner';

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (self::OWNER !== $attribute) {
            return false;
        }

        if (false === $subject instanceof Task) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();

        if (false === $user instanceof User) {
            return false;
        }

        /** @var Task $subject */
        return $subject->getOwner()->getId() === $user->getId();
    }
}
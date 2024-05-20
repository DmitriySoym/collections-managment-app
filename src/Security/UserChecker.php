<?php

namespace App\Security;

use App\Entity\User as AppUser;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof AppUser) {
            return;
        }

        if (in_array('ROLE_BLOCKED', ($user->getRoles()))) {
            throw new CustomUserMessageAccountStatusException('Your user account is blocked.');
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        return;
    }
}
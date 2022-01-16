<?php

declare(strict_types=1);

namespace App\User\Service;

use App\Core\Service\EntityManagerConstructor;
use App\User\Entity\User;
use App\User\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager extends EntityManagerConstructor
{
    private UserRepository $userRepo;
    private UserPasswordHasherInterface $hasher;

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $userRepo,
        UserPasswordHasherInterface $hasher
    ) {
        parent::__construct($em);

        $this->userRepo = $userRepo;
        $this->hasher = $hasher;
    }

    public function create(string $email, string $password, string $role = User::ROLE_RESTRICTED) : bool
    {
        if ($this->userRepo->findBy(['email' => $email])) {
            return false;
        }

        $newUser = new User();
        $newUser->setEmail($email);
        $newUser->setPassword($this->hasher->hashPassword($newUser, $password));
        $newUser->setRoles([$role]);
        $this->em->persist($newUser);
        $this->em->flush();

        return true;
    }
}

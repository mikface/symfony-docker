<?php

declare(strict_types=1);

namespace App\User\Service;

use App\Core\Service\EntityManagerConstructor;
use App\User\Entity\User;
use App\User\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager extends EntityManagerConstructor
{
    private UserRepository $userRepo;
    private UserPasswordEncoderInterface $encoder;

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $userRepo,
        UserPasswordEncoderInterface $encoder
    ) {
        parent::__construct($em);

        $this->userRepo = $userRepo;
        $this->encoder = $encoder;
    }

    public function create(string $email, string $password, string $role = User::ROLE_RESTRICTED) : bool
    {
        if ($this->userRepo->findBy(['email' => $email])) {
            return false;
        }

        $newUser = new User();
        $newUser->setEmail($email);
        $newUser->setPassword($this->encoder->encodePassword($newUser, $password));
        $newUser->setRoles([$role]);
        $this->em->persist($newUser);
        $this->em->flush();

        return true;
    }
}

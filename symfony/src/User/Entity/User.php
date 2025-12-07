<?php

declare(strict_types=1);

namespace App\User\Entity;

use App\User\Enum\Role;
use App\User\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidV7Generator;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Webmozart\Assert\Assert;

use function array_unique;
use function array_values;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\Column(type: 'uuid', unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: UuidV7Generator::class)]
    public UuidInterface $id;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    public string $email;

    /** @var list<string> $roles */
    #[ORM\Column(type: 'json')]
    public array $roles = [];

    #[ORM\Column(type: 'string')]
    public string $password;

    public function getUserIdentifier(): string {
        Assert::stringNotEmpty($this->email);

        return $this->email;
    }

    /**
     * @return list<string>
     *
     * @see UserInterface
     */
    public function getRoles(): array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = Role::USER->value;

        return array_values(array_unique($roles));
    }

    /** @see UserInterface */
    public function getPassword(): string {
        return $this->password;
    }
}

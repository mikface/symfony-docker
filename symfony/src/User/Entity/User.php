<?php

declare(strict_types=1);

namespace App\User\Entity;

use App\User\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

use function array_unique;

/** @ORM\Entity(repositoryClass=UserRepository::class) */
class User implements UserInterface
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_RESTRICTED = 'ROLE_RESTRICTED';
    public const ROLE_LOGGER = 'ROLE_LOGGER';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /** @ORM\Column(type="string", length=180, unique=true) */
    private string $email;

    /**
     * @ORM\Column(type="json")
     *
     * @var array<string>
     */
    private array $roles = [];

    /** @ORM\Column(type="string") */
    private string $password;

    public function getId() : ?int
    {
        return $this->id;
    }

    public function getEmail() : ?string
    {
        return $this->email;
    }

    public function setEmail(string $email) : self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername() : string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return array<string>
     */
    public function getRoles() : array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /** @param array<string> $roles */
    public function setRoles(array $roles) : self
    {
        $this->roles = $roles;

        return $this;
    }

    /** @see UserInterface */
    public function getPassword() : string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password) : self
    {
        $this->password = $password;

        return $this;
    }

    /** @see UserInterface */
    public function getSalt() : void
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /** @see UserInterface */
    public function eraseCredentials() : void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}

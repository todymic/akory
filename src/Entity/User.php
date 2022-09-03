<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints as Assert;

abstract class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email()
     */
    protected string $email;

    /**
     * @ORM\Column(type="json")
     */
    protected array $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    protected string $password;

    /**
     * @SerializedName("password")
     */
    protected ?string $plainPassword = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected ?string $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected string $lastName;

    /**
     * @ORM\Column(type="boolean")
     */
    protected bool $isVerified = false;

    /**
     * @var string|null
     * @ORM\Column(type="string", nullable=true)
     */
    protected ?string $avatar;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return $this
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @return $this
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return $this
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return $this
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @return $this
     */
    public function setLastName(string $LastName): self
    {
        $this->lastName = $LastName;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function setPlainPassword(?string $plainPassword = null): User
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }
    public function getAvatarUrl(): ?string
    {
        if (!$this->avatar) {
            return null;
        }
        if (str_contains($this->avatar, '/')) {
            return $this->avatar;
        }
        return sprintf('/uploads/avatars/%s', $this->avatar);
    }

    public function setAvatar(?string $avatar): void
    {
        $this->avatar = $avatar;
    }
}

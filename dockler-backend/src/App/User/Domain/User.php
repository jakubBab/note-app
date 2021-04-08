<?php

namespace App\App\User\Domain;

use App\App\Shared\Domain\TimestampableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\Annotation\Exclude;
use JMS\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\LegacyPasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 * @UniqueEntity(fields={"email"})
 * @method string getUserIdentifier()
 */
class User implements UserInterface, LegacyPasswordAuthenticatedUserInterface
{
    use TimestampableTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"user"})
     */
    private $id;

    /** @ORM\Column(type="string", length=100)
     * @Groups({"user"})
     */
    private $uuid;

    /** @ORM\Column(type="string", length=100)
     * @Groups({"user"})
     * @Serializer\SerializedName("firstName")
     */
    private $firstname;

    /** @ORM\Column(type="string", length=100)
     * @Groups({"user"})
     * @Serializer\SerializedName("lastName")
     */
    private $lastname;

    /** @ORM\Column(type="string",  unique=true, length=100)
     * @Groups({"user"})
     */
    private $email;

    /** @ORM\Column(type="string", length=255)
     */
    private $password;

    /** @ORM\Column(type="boolean",  nullable=true, options={"default" : true})
     * @Groups({"user"})
     * @ORM\JoinTable(name="user_role")
     */
    private $enabled = true;

    /**
     * @Exclude()
     */
    private string $plainPassword;

    /** @ORM\ManyToMany(targetEntity=Role::class, inversedBy="user", cascade={"persist"})
     * @Groups({"user"})
     */
    private $role;

    public function __construct()
    {
        $this->role = new ArrayCollection();
    }

    public function __call($name, $arguments): void
    {
        // TODO: Implement @method string getUserIdentifier()
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getEnabled()
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    public function getRoles()
    {
        $roles = [];
        /** @var Role $role */
        foreach ($this->role as $role) {
            $roles[] = $role->getName();
        }

        return array_unique($roles);
    }

    /**
     * @return Collection|Role[]
     */
    public function getRole(): Collection
    {
        return $this->role;
    }

    public function addRole(Role $role): self
    {
        if (! $this->role->contains($role)) {
            $this->role = new ArrayCollection();
            $this->role->add($role);
        }

        return $this;
    }

    public function removeRole(Role $role): self
    {
        if ($this->role->contains($role)) {
            $this->role->removeElement($role);
        }

        return $this;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->getEmail();
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials(): void
    {
    }
}

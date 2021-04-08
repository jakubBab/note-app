<?php

declare(strict_types=1);

namespace App\App\User\Domain;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Groups;

/**
 * @ORM\Entity()
 */
class Role
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /** @ORM\Column(type="string", length=255)
     * @Groups({"user"})
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="role")
     */
    private $user;

    public function __construct()
    {
        $this->user = new ArrayCollection();
    }

    public function __toString()
    {
        return sprintf('%s', $this->getName());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}

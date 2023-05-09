<?php

namespace App\Entity;

use App\Repository\RelationshipsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelationshipsRepository::class)]
class Relationships
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user = null;

    #[ORM\ManyToOne(inversedBy: 'relationships')]
    private ?User $freind = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFreind(): ?User
    {
        return $this->freind;
    }

    public function setFreind(?User $freind): self
    {
        $this->freind = $freind;

        return $this;
    }
}

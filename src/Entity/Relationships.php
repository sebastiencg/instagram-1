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

    #[ORM\ManyToOne(inversedBy: 'relationships')]
    private ?User $freind = null;

    #[ORM\ManyToOne(inversedBy: 'relationships2')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}

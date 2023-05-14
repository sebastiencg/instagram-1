<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, \Serializable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Post::class, orphanRemoval: true)]
    private Collection $posts;

    #[ORM\OneToMany(mappedBy: 'freind', targetEntity: Relationships::class)]
    private Collection $relationships;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Commentaire::class, orphanRemoval: true)]
    private Collection $commentaires;

    #[ORM\OneToOne(inversedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Image $image = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?Profil $profil = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Relationships::class)]
    private Collection $relationships2;


    public function __construct()
    {
        $this->posts = new ArrayCollection();
        $this->relationships = new ArrayCollection();
        $this->relationships2 = new ArrayCollection();
        $this->relationship = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Post>
     */
    public function getPosts(): Collection
    {
        return $this->posts;
    }

    public function addPost(Post $post): self
    {
        if (!$this->posts->contains($post)) {
            $this->posts->add($post);
            $post->setAuthor($this);
        }

        return $this;
    }

    public function removePost(Post $post): self
    {
        if ($this->posts->removeElement($post)) {
            // set the owning side to null (unless already changed)
            if ($post->getAuthor() === $this) {
                $post->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Relationships>
     */
    public function getRelationships(): Collection
    {
        return $this->relationships;
    }

    public function addRelationship(Relationships $relationship): self
    {
        if (!$this->relationships->contains($relationship)) {
            $this->relationships->add($relationship);
            $relationship->setFreind($this);
        }

        return $this;
    }

    public function removeRelationship(Relationships $relationship): self
    {
        if ($this->relationships->removeElement($relationship)) {
            // set the owning side to null (unless already changed)
            if ($relationship->getFreind() === $this) {
                $relationship->setFreind(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires->add($commentaire);
            $commentaire->setAuthor($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getAuthor() === $this) {
                $commentaire->setAuthor(null);
            }
        }

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function serialize(): ?string
    {
        // TODO: Implement serialize() method.
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
        ));
    }

    public function unserialize(string $data)
    {
        // TODO: Implement unserialize() method.
        list(
            $this->id,
            $this->username,
            $this->password,
            ) = unserialize($data);
    }

    public function __serialize(): array
    {
        // TODO: Implement __serialize() method.
        return [
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password,
        ];
    }

    public function __unserialize(array $data): void
    {
        // TODO: Implement __unserialize() method.
        $this->id = $data['id'];
        $this->username = $data['username'];
        $this->password = $data['password'];
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        // unset the owning side of the relation if necessary
        if ($profil === null && $this->profil !== null) {
            $this->profil->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($profil !== null && $profil->getUser() !== $this) {
            $profil->setUser($this);
        }

        $this->profil = $profil;

        return $this;
    }

    /**
     * @return Collection<int, Relationships>
     */
    public function getRelationships2(): Collection
    {
        return $this->relationships2;
    }

    public function addRelationships2(Relationships $relationships2): self
    {
        if (!$this->relationships2->contains($relationships2)) {
            $this->relationships2->add($relationships2);
            $relationships2->setUser($this);
        }

        return $this;
    }

    public function removeRelationships2(Relationships $relationships2): self
    {
        if ($this->relationships2->removeElement($relationships2)) {
            // set the owning side to null (unless already changed)
            if ($relationships2->getUser() === $this) {
                $relationships2->setUser(null);
            }
        }

        return $this;
    }
}

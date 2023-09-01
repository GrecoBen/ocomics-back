<?php

namespace App\Entity;

use App\Repository\UserCollectionRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=UserCollectionRepository::class)
 */
class UserCollection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"wishlist"})
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     * @Groups({"wishlist"})
     */
    private $status;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="userCollection", cascade={"persist", "remove"})
     * @Groups({"wishlist"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Comics::class, inversedBy="userCollections")
     * @Groups({"wishlist"})
     */
    private $comics;

    public function __construct()
    {
        $this->comics = new ArrayCollection();
    }

    /**
     * @return Collection<int, Comics>
     */
    public function getComics(): Collection
    {
        return $this->comics;
    }

    public function addComics(Comics $comics): self
    {
        if (!$this->comics->contains($comics)) {
            $this->comics[] = $comics;
            $comics->addUserCollection($this);
        }

        return $this;
    }

    public function removeComics(Comics $comics): self
    {
        if ($this->comics->removeElement($comics)) {
            $comics->removeUserCollection($this);
        }

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

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

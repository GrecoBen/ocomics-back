<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use App\Repository\WishCollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=WishCollectionRepository::class)
 */
class WishCollection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"wishlist"})
     */
    private $id;


    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="wishCollection", cascade={"persist", "remove"})
     * @Groups({"wishlist"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Comics::class, inversedBy="wishCollections")
     * @Groups({"wishlist"})
     */
    private $comics;

    public function __construct()
    {
        $this->comics = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return Collection<int, Comics>
     */
    public function getComics(): Collection
    {
        return $this->comics;
    }

    public function addComics(Comics $comic): self
    {
        if (!$this->comics->contains($comic)) {
            $this->comics[] = $comic;
        }

        return $this;
    }

    public function removeComics(Comics $comic): self
    {
        $this->comics->removeElement($comic);

        return $this;
    }
}

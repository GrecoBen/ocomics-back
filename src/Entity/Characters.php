<?php

namespace App\Entity;

use App\Repository\CharactersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CharactersRepository::class)
 * @ORM\Table(name="`character`")
 */
class Characters
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $alias;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $released_at;

    /**
     * @ORM\ManyToMany(targetEntity=Comics::class, mappedBy="characters")
     */
    private $comics;

    /**
     * @ORM\ManyToMany(targetEntity=UserCollection::class, mappedBy="comics")
     */
    private $userCollections;

    public function __construct()
    {
        $this->comics = new ArrayCollection();
        $this->userCollections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAlias(): ?string
    {
        return $this->alias;
    }

    public function setAlias(string $alias): self
    {
        $this->alias = $alias;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getReleasedAt(): ?\DateTimeImmutable
    {
        return $this->released_at;
    }

    public function setReleasedAt(\DateTimeImmutable $released_at): self
    {
        $this->released_at = $released_at;

        return $this;
    }

    /**
     * @return Collection<int, Comics>
     */
    public function getComics(): Collection
    {
        return $this->comics;
    }

    public function addComic(Comics $comic): self
    {
        if (!$this->comics->contains($comic)) {
            $this->comics[] = $comic;
            $comic->addCharacter($this);
        }

        return $this;
    }

    public function removeComic(Comics $comic): self
    {
        if ($this->comics->removeElement($comic)) {
            $comic->removeCharacter($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, UserCollection>
     */
    public function getUserCollections(): Collection
    {
        return $this->userCollections;
    }
}

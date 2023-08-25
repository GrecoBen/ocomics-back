<?php

namespace App\Entity;

use App\Entity\UserCollection;
use App\Repository\CharactersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;


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
     * @Groups({"characters"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"characters"})
     */
    private $poster;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Groups({"characters"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"characters"})
     */
    private $released_at;

    /**
     * @ORM\ManyToMany(targetEntity=Comics::class, mappedBy="characters")
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

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

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
}

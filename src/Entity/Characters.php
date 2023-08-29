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
     * @Groups({"characters", "charactersWithRelation", "comicsWithRelation"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"characters", "charactersWithRelation", "comicsWithRelation"})
     */
    private $poster;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     * @Groups({"characters", "charactersWithRelation", "comicsWithRelation"})
     */
    private $name;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"characters", "charactersWithRelation", "comicsWithRelation"})
     */
    private $released_at;

    /**
     * @ORM\Column(type="text")
     * @Groups({"characters", "charactersWithRelation", "comicsWithRelation"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=500, nullable=true)
     * @Groups({"characters", "charactersWithRelation", "comicsWithRelation"})
     */
    private $quote;

    /**
     * @ORM\ManyToMany(targetEntity=Comics::class, mappedBy="characters")
     * @Groups({"charactersWithRelation"})
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getQuote(): ?string
    {
        return $this->quote;
    }

    public function setQuote(?string $quote): self
    {
        $this->quote = $quote;

        return $this;
    }
}

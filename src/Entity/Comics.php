<?php

namespace App\Entity;

use App\Entity\UserCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComicsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ComicsRepository::class)
 */
class Comics
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"comics"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"comics"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"comics"})
     */
    private $poster;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"comics"})
     */
    private $released_at;

    /**
     * @ORM\Column(type="text")
     * @Groups({"comics"})
     */
    private $synopsis;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"comics"})
     */
    private $rarity;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="comics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=Characters::class, inversedBy="comics")
     */
    private $characters;

    /**
     * @ORM\ManyToMany(targetEntity=UserCollection::class, mappedBy="comics")
     */
    private $userCollections;


    public function __construct()
    {
        $this->characters = new ArrayCollection();
        $this->userCollections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
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

    public function getReleasedAt(): ?\DateTimeImmutable
    {
        return $this->released_at;
    }

    public function setReleasedAt(\DateTimeImmutable $released_at): self
    {
        $this->released_at = $released_at;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getRarity(): ?int
    {
        return $this->rarity;
    }

    public function setRarity(?int $rarity): self
    {
        $this->rarity = $rarity;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, characters>
     */
    public function getCharacters(): Collection
    {
        return $this->characters;
    }

    public function addCharacter(characters $character): self
    {
        if (!$this->characters->contains($character)) {
            $this->characters[] = $character;
        }

        return $this;
    }

    public function removeCharacter(characters $character): self
    {
        $this->characters->removeElement($character);

        return $this;
    }

    /**
     * @return Collection<int, UserCollection>
     */
    public function getUserCollections(): Collection
    {
        return $this->userCollections;
    }

    public function addUserCollection(UserCollection $userCollection): self
    {
        if (!$this->userCollections->contains($userCollection)) {
            $this->userCollections[] = $userCollection;
            $userCollection->addComics($this);
        }

        return $this;
    }

    public function removeUserCollection(UserCollection $userCollection): self
    {
        if ($this->userCollections->removeElement($userCollection)) {
            $userCollection->removeComics($this);
        }

        return $this;
    }
}

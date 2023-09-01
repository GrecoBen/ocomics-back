<?php

namespace App\Entity;

use App\Entity\UserCollection;
use App\Entity\WishCollection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ComicsRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ComicsRepository::class)
 */
class Comics
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"comics","charactersWithRelation","comicsWithRelation", "wishlist"})
     */
    private $id;

     /**
     * @ORM\Column(type="string", length=128)
     * @Groups({"comics", "charactersWithRelation", "comicsWithRelation","wishlist"})
     * @Assert\NotBlank
     * @Assert\Length(max=128)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"comics", "charactersWithRelation", "comicsWithRelation","wishlist"})
     * @Assert\NotBlank
     * @Assert\Url
     */
    private $poster;

    /**
     * @ORM\Column(type="datetime_immutable")
     * @Groups({"comics", "charactersWithRelation", "comicsWithRelation"})
     * @Assert\NotBlank
     */
    private $released_at;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"comics", "charactersWithRelation", "comicsWithRelation"})
     */
    private $synopsis;

    /**
     * @ORM\Column(type="smallint", nullable=true)
     * @Groups({"comics", "charactersWithRelation", "comicsWithRelation"})
     */
    private $rarity;

    /**
     * @ORM\ManyToOne(targetEntity=Author::class, inversedBy="comics")
     * @ORM\JoinColumn(nullable=true)
     * @Groups({"comicsWithRelation"})
     */
    private $author;

    /**
     * @ORM\ManyToMany(targetEntity=Characters::class, inversedBy="comics")
     * @Groups({"comicsWithRelation"})
     */
    private $characters;

    /**
     * @ORM\ManyToMany(targetEntity=UserCollection::class, mappedBy="comics")
     */
    private $userCollections;

    /**
     * @ORM\ManyToMany(targetEntity=WishCollection::class, mappedBy="comics")
     */
    private $wishCollections;


    public function __construct()
    {
        $this->characters = new ArrayCollection();
        $this->userCollections = new ArrayCollection();
        $this->wishCollections = new ArrayCollection();
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

    /**
     * @return Collection<int, WishCollection>
     */
    public function getWishCollections(): Collection
    {
        return $this->wishCollections;
    }

    public function addWishCollection(WishCollection $wishCollection): self
    {
        if (!$this->wishCollections->contains($wishCollection)) {
            $this->wishCollections[] = $wishCollection;
            $wishCollection->addComics($this);
        }

        return $this;
    }

    public function removewishCollection(wishCollection $wishCollection): self
    {
        if ($this->wishCollections->removeElement($wishCollection)) {
            $wishCollection->removeComics($this);
        }

        return $this;
    }
}

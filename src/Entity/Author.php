<?php

namespace App\Entity;

use App\Repository\AuthorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AuthorRepository::class)
 */
class Author
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"comicsWithRelation"})
     */
    private $id;

      /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"comicsWithRelation"})
     * @Assert\NotBlank
     * @Assert\Length(max=64)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=64)
     * @Groups({"comicsWithRelation"})
     * @Assert\NotBlank
     * @Assert\Length(max=64)
     */
    private $lastname;

    /**
     * @ORM\OneToMany(targetEntity=Comics::class, mappedBy="author", orphanRemoval=true)
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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

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
            $comic->setAuthor($this);
        }

        return $this;
    }

    public function removeComic(Comics $comic): self
    {
        if ($this->comics->removeElement($comic)) {
            // set the owning side to null (unless already changed)
            if ($comic->getAuthor() === $this) {
                $comic->setAuthor(null);
            }
        }

        return $this;
    }
}

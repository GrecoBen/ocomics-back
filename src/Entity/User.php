<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"wishlist"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\NotBlank
     * @Assert\Email
     * @Groups({"wishlist"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank
     */
    private $username;

    /**
     * @ORM\OneToOne(targetEntity=UserCollection::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $userCollection;

    /**
     * @ORM\OneToMany(targetEntity=UserCollection::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $userCollections;

    /**
     * @ORM\OneToOne(targetEntity=WishCollection::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $wishCollection;

    public function __construct()
    {
        $this->userCollections = new ArrayCollection();
    }

    /**
     * @return Collection<int, UserCollection>
     */
    public function getUserCollections(): Collection
    {
        return $this->userCollections;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
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
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUserCollection(): ?UserCollection
    {
        return $this->userCollection;
    }

    public function setUserCollection(?UserCollection $userCollection): self
    {
        // unset the owning side of the relation if necessary
        if ($userCollection === null && $this->userCollection !== null) {
            $this->userCollection->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($userCollection !== null && $userCollection->getUser() !== $this) {
            $userCollection->setUser($this);
        }

        $this->userCollection = $userCollection;

        return $this;
    }

    public function getWishCollection(): ?WishCollection
    {
        return $this->wishCollection;
    }

    public function setWishCollection(?WishCollection $wishCollection): self
    {
        // unset the owning side of the relation if necessary
        if ($wishCollection === null && $this->wishCollection !== null) {
            $this->wishCollection->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($wishCollection !== null && $wishCollection->getUser() !== $this) {
            $wishCollection->setUser($this);
        }

        $this->wishCollection = $wishCollection;

        return $this;
    }
}

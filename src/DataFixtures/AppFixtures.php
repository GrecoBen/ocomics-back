<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Author;
use App\Entity\Comics;
use App\Entity\Characters;
use App\Entity\UserCollection;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\Provider\AppProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    // ! Ceci est de l'injection de dépandance
    private $passwordHasher;
    
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        // ici j'ajoute mon provider personnalisé
        $faker->addProvider(new AppProvider());

        //! Author
        // Create an Author that will br link to a Comics
        for ($j= 0; $j < 20; $j++) {
            $author = new Author();
            $author->setFirstname($faker->firstName);
            $author->setLastname($faker->lastName);
            $manager->persist($author);
            $authors[] = $author;
        }

        //! Characters
        for ($k=0; $k < 20; $k++) {
            $character = new Characters();
            $character->setAlias($faker->firstName);
            $character->setName($faker->lastName);
            $character->setReleasedAt(new \DateTimeImmutable($faker->date()));
            $manager->persist($character);
            $characters[] = $character;
        }

        //! Comics
        for ($i = 0; $i < 20; $i++) {
            $comics = new Comics();
            $comics->setTitle($faker->words(3, true));
            $comics->setReleasedAt(new \DateTimeImmutable($faker->date()));
            $comics->setSynopsis($faker->paragraphs(5, true));
            $comics->setPoster("https://picsum.photos/id/" . mt_rand(50, 120) . "/768/1024");
            $comics->setRarity($faker->randomFloat(1, 1, 5));

            // Link the author and the comics
            $randomAuthor = $authors[array_rand($authors)];
            $comics->setAuthor($randomAuthor);

            // Link the character and the comics
            $randomCharacter = $characters[array_rand($characters)];
            $comics->addCharacter($randomCharacter);
            $manager->persist($comics);
        }

        //! USER

        for ($l = 0; $l < 6; $l++) {
            // j'utilise mon provider pour récupérer un user unique
            $dataUser = $faker->unique()->user();
            // J'instancie un nouvel obJet user
            $user = new User();
            // Je set l'email, c'est une string simple
            $user->setEmail($dataUser["email"]);
            // Je set les roles, c'est un tableau
            $user->setRoles($dataUser["roles"]);
            $user->setUsername($faker->text(15));
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            // Je set le password, c'est une string simple
            // J'utilise le passwordHasher passé au constructeur, ça s'appelle de l'injection de dépendance (on en parlera dans les prochains jours), il contient la méthode hashPassword qui permet de changer une string en hash par rapport à la méthode de hashage définis dans security.yaml
            // ! SI PAS DE HASH, PAS POSSIBLE DE S'AUTHENTIFIER
            // ! DE PLUS UN MDP EN CLAIR EN BDD EST A LA LIMITE DE L'ILLEGALITE
            $user->setPassword($this->passwordHasher->hashPassword($user, $dataUser["password"]));
        
            // On oublis pas de persister l'objet
            $manager->persist($user);
            $users[] = $user;
        }

        //! UserCollection avec les utilisateurs créés en dur

        $userCollectionUsers = [];
        for ($l = 0; $l < 6; $l++) {
            $userCollection = new UserCollection();
            $userCollection->setStatus($faker->randomElement([0, 1, 2]));
        
            // Link the user and the user collection (randomly choose from existing users)
            $randomUser = $faker->randomElement($users);
            if (!in_array($randomUser, $userCollectionUsers)) {
                $userCollection->setUser($randomUser);
                $userCollectionUsers[] = $randomUser;
            }
        
            // Link the comics and the user collection (your existing code)
        
            $manager->persist($userCollection);
        }

        $manager->flush();
    }
}

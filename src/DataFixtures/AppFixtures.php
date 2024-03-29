<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use App\Entity\Author;
use App\Entity\Comics;
use App\Entity\Characters;
use App\Entity\UserCollection;
use App\Entity\WishCollection;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\Provider\AppProvider;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    //Dependency injection
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        // Our custom provider for the user data
        $faker->addProvider(new AppProvider());

        // Initialition of three arrays, to store comics and users object in an array for the user_collection_comics fixture
        $comicsArray = [];
        $usersArray = [];

        //! Author
        // Create several Authors that will br link to a Comics
        for ($j = 0; $j < 20; $j++) {
            $author = new Author();
            $author->setFirstname($faker->firstName);
            $author->setLastname($faker->lastName);
            $manager->persist($author);
            $authors[] = $author;
        }

        //! Characters
        //Create several characters that will be link to a Comics
        for ($k = 0; $k < 20; $k++) {
            $character = new Characters();

            $randomCharacterInfo = $faker->randomElement($faker->charactersInfos());

            $character->setPoster($randomCharacterInfo['poster']);
            $character->setName($randomCharacterInfo['name']);
            $character->setReleasedAt(new \DateTimeImmutable($faker->date()));
            $character->setDescription($faker->text(600));
            $character->setQuote($faker->text(75));
            $manager->persist($character);
            $characters[] = $character;
        }

        //! Comics
        //Create several comics 
        for ($i = 0; $i < 20; $i++) {
            $comics = new Comics();

            $randomComicInfo = $faker->randomElement($faker->comicsInfos());

            $comics->setTitle($randomComicInfo['title']);
            $comics->setReleasedAt(new \DateTimeImmutable($faker->date()));
            $comics->setSynopsis($faker->paragraphs(5, true));
            $comics->setPoster($randomComicInfo['poster']);
            $comics->setRarity($faker->randomFloat(1, 1, 5));

            // Link the author to the created comics
            $randomAuthor = $authors[array_rand($authors)];
            $comics->setAuthor($randomAuthor);

            // Link the character to the created comics
            $randomCharacter = $characters[array_rand($characters)];
            $comics->addCharacter($randomCharacter);
            $manager->persist($comics);
            // insert the comics object in the array
            $comicsArray[] = $comics;
        }

        //! USER

        for ($l = 0; $l < 6; $l++) {
            // we user our custom provider to get unique user
            $dataUser = $faker->unique()->user();
            // Instanciation of the user object
            $user = new User();

            $user->setEmail($dataUser["email"]);
            $user->setRoles($dataUser["roles"]);
            $user->setUsername($faker->text(15));
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            // In order to set the password, we need to use the passwordHasher initialize threw the constructor and hash it. security.yaml is provided by symfony with a password hasher method
            $user->setPassword($this->passwordHasher->hashPassword($user, $dataUser["password"]));

            $manager->persist($user);
            // insert the user object in the array
            $usersArray[] = $user;
        }

        //! UserCollection

        for ($m = 0; $m < 6; $m++) {
            $userCollection = new UserCollection();

            // Determine the random number of comics to add (between 0 and 5)
            $numComicsToAdd = mt_rand(0, 5);

            // Add the specified number of comics to the UserCollection
            for ($i = 0; $i < $numComicsToAdd; $i++) {
                $randomComic = $comicsArray[array_rand($comicsArray)];
                $userCollection->addComics($randomComic);
            }

            // Link the user and the UserCollection
            $randomUser = $usersArray[$m];
            $userCollection->setUser($randomUser);

            $manager->persist($userCollection);
        }
        //! wishCollection

        for ($n = 0; $n < 6; $n++) {
            $wishCollection = new WishCollection();

            // Determine the random number of comics to add (between 0 and 5)
            $numComicsToAdd = mt_rand(0, 5);

            // Add the specified number of comics to the wishCollection
            for ($i = 0; $i < $numComicsToAdd; $i++) {
                $randomComic = $comicsArray[array_rand($comicsArray)];
                $wishCollection->addComics($randomComic);
            }

            // Link the user and the wishCollection
            $randomUser = $usersArray[$n];
            $wishCollection->setUser($randomUser);

            $manager->persist($wishCollection);
        }
        $manager->flush();
    }
}

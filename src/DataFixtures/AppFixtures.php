<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Comics;
use App\Entity\Characters;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Author; // N'oubliez pas d'importer l'entité Author

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

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

        $manager->flush();
    }
}

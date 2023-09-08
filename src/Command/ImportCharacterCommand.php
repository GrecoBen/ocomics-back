<?php

namespace App\Command;

use App\Entity\Characters; 
use App\Service\MarvelApiUrlGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use DateTimeImmutable;

class ImportCharacterCommand extends Command
{
    protected static $defaultName = 'app:import-character'; // Updated command name
    private $urlGenerator;
    private $entityManager;

    public function __construct(MarvelApiUrlGenerator $urlGenerator, EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->urlGenerator = $urlGenerator;
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setDescription('Import Marvel characters data from API') // Updated description
            ->setHelp('This command imports Marvel characters data from the API and stores it in the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Generate the URL for characters information
        $url = $this->urlGenerator->generateCharactersUrl();
        
        // Create an HTTP client instance
        $httpClient = HttpClient::create();
        
        // Send a GET request to the generated URL
        $response = $httpClient->request('GET', $url);
        
        // Convert the JSON response to an array
        $data = $response->toArray();

        // Get the Marvel characters data
        $marvelCharacters = $data['data']['results'];

        // Save the data in the database
foreach ($marvelCharacters as $characterData) {
    $character = new Characters(); // Use the Characters entity
    $character->setName($characterData['name']);

    // Check if there is a thumbnail for the comic
    if (isset($characterData['thumbnail']['path']) && isset($characterData['thumbnail']['extension'])) {
        $thumbnailUrl = $characterData['thumbnail']['path'] . '.' . $characterData['thumbnail']['extension'];

        // Check if the thumbnail URL does not end with "image_not_available.jpg"
        if (!preg_match('/image_not_available\.jpg$/', $thumbnailUrl)) {
            $character->setPoster($thumbnailUrl);
            $character->setDescription($characterData['description']);


            // Generate a random release date
            $randomTimestamp = mt_rand(strtotime('-10 years'), time());
            $randomDate = DateTimeImmutable::createFromFormat('U', $randomTimestamp);
            $character->setReleasedAt($randomDate);

            // Persist the character entity
            $this->entityManager->persist($character);
        }
    }
}    

        // Execute the database operations
        $this->entityManager->flush();

        // Display success message
        $io->success('Marvel characters data imported successfully!');

        return Command::SUCCESS;
    }
}

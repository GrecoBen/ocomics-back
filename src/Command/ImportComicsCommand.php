<?php

namespace App\Command;

use App\Entity\Comics;
use App\Service\MarvelApiUrlGenerator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpClient\HttpClient;
use DateTimeImmutable;

class ImportComicsCommand extends Command
{
    protected static $defaultName = 'app:import-comics';
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
            ->setDescription('Import Marvel comics data from API')
            ->setHelp('This command imports Marvel comics data from the API and stores it in the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Generate the URL for comics information
        $url = $this->urlGenerator->generateComicsUrl();

        // Create an HTTP client instance
        $httpClient = HttpClient::create();

        // Send a GET request to the generated URL
        $response = $httpClient->request('GET', $url);

        // Convert the JSON response to an array
        $data = $response->toArray();

        // Get the Marvel comics data
        $marvelComics = $data['data']['results'];

        // Save the data in the database
        foreach ($marvelComics as $comicData) {
            $comic = new Comics();
            $comic->setTitle($comicData['title']);

            if (isset($comicData['description'])) {
                $comic->setSynopsis($comicData['description']);
            }
            // Check if there is a thumbnail for the comic
            if (isset($comicData['thumbnail']['path']) && isset($comicData['thumbnail']['extension'])) {
                $thumbnailUrl = $comicData['thumbnail']['path'] . '.' . $comicData['thumbnail']['extension'];

                // Check if the thumbnail URL does not end with "image_not_available.jpg"
                if (!preg_match('/image_not_available\.jpg$/', $thumbnailUrl)) {
                    $comic->setPoster($thumbnailUrl);

                    // Generate a random release date
                    $randomTimestamp = mt_rand(strtotime('-10 years'), time());
                    $randomDate = DateTimeImmutable::createFromFormat('U', $randomTimestamp);
                    $comic->setReleasedAt($randomDate);

                    // Persist the comic entity
                    $this->entityManager->persist($comic);
                }
            }
        }

        // Execute the database operations
        $this->entityManager->flush();

        // Display success message
        $io->success('Marvel comics data imported successfully!');

        return Command::SUCCESS;
    }
}

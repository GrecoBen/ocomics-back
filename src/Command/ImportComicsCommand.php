<?php

namespace App\Command;

use App\Entity\Comics;
use App\Entity\Characters;
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

        $url = $this->urlGenerator->generateComicsUrl();
        $httpClient = HttpClient::create();
        $response = $httpClient->request('GET', $url);
        $data = $response->toArray();

        $marvelComics = $data['data']['results'];

        // Enregistrez les données dans la base de données
        foreach ($marvelComics as $comicData) {
            $comic = new Comics();
            $comic->setTitle($comicData['title']);
            $comic->setSynopsis($comicData['description']);

            $thumbnailUrl = $comicData['thumbnail']['path'] . '.' . $comicData['thumbnail']['extension'];
            $comic->setPoster($thumbnailUrl);

            $randomTimestamp = mt_rand(strtotime('-10 years'), time());
            $randomDate = DateTimeImmutable::createFromFormat('U', $randomTimestamp);
            $comic->setReleasedAt($randomDate);

        
            $this->entityManager->persist($comic);
        }        

        // Exécuter les opérations d'enregistrement
        $this->entityManager->flush();

        $io->success('Marvel comics data imported successfully!');

        return Command::SUCCESS;
    }
}

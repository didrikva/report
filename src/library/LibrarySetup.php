<?php

namespace App\library;
use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LibrarySetup
{
    /**
     * constructor to set upp the controller
     */
    public function __construct(
        private ManagerRegistry $doctrine,
        private LibraryRepository $libraryRepository
    ){}
    /**
     * Creates the setup for LibraryController
     */
    private function setUp(): void
    {
        
            $entityManager = $this->doctrine->getManager();
        
            $library = new Library();
            $library->setTitel('The lord of the rings');
            $library->setIsbn(200);
            $library->setForfattare('J.k. Rowling');
            $library->setImg('img/lordOfTheRings.jpeg');

            $entityManager->persist($library);

            $book = new Library();
            $book->setTitel('Harry Potter');
            $book->setIsbn(556);
            $book->setForfattare('J.R.R. Tolkien');
            $book->setImg('img/HarryPotter.jpeg');

            $entityManager->persist($book);

            $bibel = new Library();
            $bibel->setTitel('Bibeln');
            $bibel->setIsbn(1);
            $bibel->setForfattare('Jesus');
            $bibel->setImg('img/Bibeln.jpeg');

            $entityManager->persist($bibel);

            $entityManager->flush();
    }
    /**
     * Creates the setup for LibraryController
     */
    public function checkSetUp(): void
    {

        $all = $this->libraryRepository
            ->findAll();
        if (!empty($all)) {
            return;
        }
        $this->setUp();
    }
    
}

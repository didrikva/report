<?php

namespace App\library;
use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LibrarySetup
{
    /**
     * construktro to set upp the controller
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
        $entityManager = $this->doctrine->getManager();

        $all = $this->libraryRepository
            ->findAll();
        if (!empty($all)) {
            return;
        }
        $this->setUp();
    }
    /**
     * Adds new book into the database
     */
    public function insert(string $titel, int $isbn, string $forfattare, string $img=null): void
    {
        $entityManager = $this->doctrine->getManager();
        $new = new Library();
        $new->setTitel($titel);
        $new->setIsbn($isbn);
        $new->setForfattare($forfattare);
        $new->setImg($img);

        $entityManager->persist($new);
        $entityManager->flush();
    }
    /**
     * Updates the database with new values
     */
    public function update(int $id, string $titel, int $isbn, string $forfattare, string $img=null): void
    {
        $entityManager = $this->doctrine->getManager();
        $update = $entityManager->getRepository(library::class)->find($id);
         if (!$update) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }
        $update->setTitel($titel);
        $update->setIsbn($isbn);
        $update->setForfattare($forfattare);
        $update->setImg($img);

        $entityManager->persist($update);
        $entityManager->flush();
    }
}

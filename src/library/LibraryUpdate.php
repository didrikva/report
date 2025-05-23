<?php

namespace App\library;
use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LibraryUpdate
{
    /**
     * constructor to set upp the controller
     */
    public function __construct(
        private ManagerRegistry $doctrine,
        private LibraryRepository $libraryRepository
    ){}
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
            throw new \Exception('No book found for id ' . $id);
        }
        $update->setTitel($titel);
        $update->setIsbn($isbn);
        $update->setForfattare($forfattare);
        $update->setImg($img);

        $entityManager->persist($update);
        $entityManager->flush();
    }
}

<?php

namespace App\Controller;
use App\Entity\Library;
use App\library\LibrarySetup;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LibraryControllerAPI extends AbstractController
{
    #[Route('api/library/show', name: 'library_show_all_api')]
    public function showAllApi(
        LibraryRepository $libraryRepository
    ): Response {
        $library = $libraryRepository
            ->findAll();

        return $this->json($library);
    }
    #[Route('api/library/book/{isbn}', name: 'library_search')]
    public function showBookIsbn(
        LibraryRepository $libraryRepository,
        int $isbn
    ): Response {
        $library = $libraryRepository->findByValue($isbn);
        return $this->json($library);
    }
}

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

final class LibraryControllerView extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(
        LibrarySetup $librarySetup
    ): Response
    {
        $librarySetup->checkSetUp();

        
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }
    #[Route('/library/show', name: 'library_show_all')]
    public function showAllProduct(
        LibraryRepository $libraryRepository
    ): Response {
        $library = $libraryRepository
            ->findAll();

        return $this->json($library);
    }
    #[Route('/library/view', name: 'library_view_all')]
    public function viewAllProduct(
        LibraryRepository $libraryRepository
    ): Response {
        $library = $libraryRepository->findAll();

        $data = [
            'librarys' => $library
        ];

        return $this->render('library/view.html.twig', $data);
    }
    #[Route('/library/view/{id}', name: 'view_one')]
    public function view(
        ManagerRegistry $doctrine,
        int $id
    ): Response
    {
        $entityManager = $doctrine->getManager();
        $library = $entityManager->getRepository(library::class)->find($id);
        return $this->render('library/one.html.twig', [
            'library' => $library,
        ]);
    }
}

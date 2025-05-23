<?php

namespace App\Controller;
use App\Entity\Library;
use App\library\LibraryUpdate;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LibraryController extends AbstractController
{
    #[Route('/library/create', name: 'library_create_get', methods: ['GET'])]
    public function createGet(
        LibraryRepository $libraryRepository
    ): Response
    {
        $books = $libraryRepository->findAll();
        $library = $books[0];
        
        return $this->render('library/create.html.twig', [
            'library' => $library,
        ]);
    }
    #[Route('/library/create', name: 'library_create_post', methods: ['POST'])]
    public function createPost(
        Request $request,
        LibraryUpdate $libraryUpdate
    ): Response
    {
        $titel = $request->request->get('titel');
        $isbn = $request->request->get('isbn');
        $forfattare = $request->request->get('forfattare');
        $img = $request->request->get('img');
        $libraryUpdate->insert($titel,$isbn,$forfattare,$img);
        return $this->redirectToRoute('library_view_all');
    }
    #[Route('/library/delete/{id}', name: 'library_delete_by_id')]
    public function deletelibraryById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $library = $entityManager->getRepository(library::class)->find($id);

        if (!$library) {
            throw $this->createNotFoundException(
                'No library found for id '.$id
            );
        }

        $entityManager->remove($library);
        $entityManager->flush();

        return $this->redirectToRoute('library_view_all');
    }
    #[Route('/library/update/{id}', name: 'library_update_get', methods: ['GET'])]
    public function updateGet(
        ManagerRegistry $doctrine,
        int $id
    ): Response
    {
        $entityManager = $doctrine->getManager();
        $library = $entityManager->getRepository(library::class)->find($id);
        return $this->render('library/update.html.twig', [
            'library' => $library,
        ]);
    }
    #[Route('/library/update/{id}', name: 'library_update_post', methods: ['POST'])]
    public function updatePost(
        Request $request,
        ManagerRegistry $doctrine,
        LibraryUpdate $libraryUpdate,
        int $id
    ): Response
    {
        $titel = $request->request->get('titel');
        $isbn = $request->request->get('isbn');
        $forfattare = $request->request->get('forfattare');
        $img = $request->request->get('img');
        
        $libraryUpdate->update($id, $titel,$isbn,$forfattare,$img);
        return $this->redirectToRoute('library_view_all');
    }
}

<?php

namespace App\Controller;
use App\Entity\Library;
use App\Repository\LibraryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(
        ManagerRegistry $doctrine,
        LibraryRepository $libraryRepository
    ): Response
    {
        $entityManager = $doctrine->getManager();

        $all = $libraryRepository
            ->findAll();
        if ($all === 0) {
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
        LibraryRepository $libraryRepository,
        ManagerRegistry $doctrine,
    ): Response
    {
        $titel = $request->request->get('titel');
        $isbn = $request->request->get('isbn');
        $forfattare = $request->request->get('forfattare');
        $img = $request->request->get('img');
        $entityManager = $doctrine->getManager();
        $new = new Library();
        $new->setTitel($titel);
        $new->setIsbn($isbn);
        $new->setForfattare($forfattare);
        $new->setImg($img);

        $entityManager->persist($new);
        $entityManager->flush();
        $library = $libraryRepository->findAll();
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
        LibraryRepository $libraryRepository,
        ManagerRegistry $doctrine,
        int $id
    ): Response
    {
        $entityManager = $doctrine->getManager();
        $update = $entityManager->getRepository(library::class)->find($id);
        $titel = $request->request->get('titel');
        $isbn = $request->request->get('isbn');
        $forfattare = $request->request->get('forfattare');
        $img = $request->request->get('img');
        $update->setTitel($titel);
        $update->setIsbn($isbn);
        $update->setForfattare($forfattare);
        $update->setImg($img);

        $entityManager->persist($update);
        $entityManager->flush();
        $library = $libraryRepository->findAll();
        return $this->redirectToRoute('library_view_all');
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

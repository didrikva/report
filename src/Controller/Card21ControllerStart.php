<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\game_21\Card21Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class Card21ControllerStart extends AbstractController
{
    #[Route('/game', name: 'game21')]
    public function initCallback(
    ): Response {
        return $this->render('21_game/home21.html.twig');
    }

    #[Route('/game/doc', name: 'document')]
    public function document(
    ): Response {
        return $this->render('21_game/doc.html.twig');
    }

    #[Route('/game/start', name: 'gameStart', methods: ['GET'])]
    public function start(
    ): Response {
        return $this->render('21_game/start.html.twig');
    }

    #[Route('/game/start', name: 'gameStartPost', methods: ['POST'])]
    public function drawCard(
        SessionInterface $session,
    ): Response {
        $session->clear();

        return $this->redirectToRoute('getCards');
    }
}

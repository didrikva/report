<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\game_21\Card21Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BlackJackControllerStart extends AbstractController
{
    #[Route('/proj', name: 'projHome')]
    public function proj(
    ): Response {
        return $this->render('blackjack/start.html.twig');
    }

    #[Route('/game/about', name: 'projAbout')]
    public function about(
    ): Response {
        return $this->render('blackjack/about.html.twig');
    }
    #[Route('/game/start', name: 'projStart')]
    public function play(
    ): Response {
        return $this->render('blackjack/play.html.twig');
    }
}

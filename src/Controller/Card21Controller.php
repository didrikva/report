<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class Card21Controller extends AbstractController
{
    #[Route('/21', name: 'game_21')]
    public function initCallback(
        Request $request,
        SessionInterface $session,
    ): Response {
        

        return $this->render('21_game/home21.html.twig');
    }
    #[Route('/21/start', name: 'game_start')]
    public function start(
        Request $request,
        SessionInterface $session,
    ): Response {
        

        return $this->render('21_game/start.html.twig');
    }
    #[Route('/21/play', name: 'get_cards')]
    public function get_cards(
        Request $request,
        SessionInterface $session,
    ): Response {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $session->set('deck', $deck);
        $num = 1;
        $deck->draw($num);
        // var_dump($deck);
        $data = [
            'hand' => $deck->getDrawn(),
        ];
        $session->set('hand', $deck->getDrawn());

        return $this->render('21_game/play.html.twig', $data);
    }
    #[Route('/21/draw', name: 'draw_card')]
    public function draw_card(
        Request $request,
        SessionInterface $session,
    ): Response {
        $hand = $session->get('hand');
        $deck = $session->get('deck');
        // var_dump($deck);
        $num = 1;
        $deck->draw($num);
        $new = $deck->getDrawn();
        $hand = array_merge($hand,$new);
        $data = [
            'hand' => $hand,
        ];
        $session->set('hand', $hand);

        return $this->render('21_game/play.html.twig', $data);
    }
}
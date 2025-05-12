<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\game_21\Card21Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class Card21Controller extends AbstractController
{
    #[Route('/game', name: 'game_21')]
    public function initCallback(
    ): Response {
        return $this->render('21_game/home21.html.twig');
    }

    #[Route('/game/doc', name: 'document')]
    public function document(
    ): Response {
        return $this->render('21_game/doc.html.twig');
    }

    #[Route('/game/start', name: 'game_start', methods: ['GET'])]
    public function start(
    ): Response {
        return $this->render('21_game/start.html.twig');
    }

    #[Route('/game/start', name: 'game_start_post', methods: ['POST'])]
    public function drawCard(
        SessionInterface $session,
    ): Response {
        $session->clear();

        return $this->redirectToRoute('get_cards');
    }

    #[Route('/game/play', name: 'get_cards')]
    public function get_cards(
        SessionInterface $session,
    ): Response {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $game21 = new Card21Game();
        $session->set('deck', $deck);
        $session->set('game21', $game21);
        $gameOver = false;
        $num = 1;
        $deck->draw($num);
        $points = $game21->getPlayerPoints($deck->getDrawn());
        $session->set('hand', $deck->getDrawn());
        $session->set('points', $points);
        $session->set('game_over', $gameOver);
        $data = [
            'hand' => $deck->getDrawn(),
            'points' => $points,
            'bank' => [],
            'bankPoints' => 0,
            'gameOver' => $game21->endGame(),
        ];

        return $this->render('21_game/play.html.twig', $data);
    }

    #[Route('/game/draw', name: 'draw_card')]
    public function draw_card(
        SessionInterface $session,
    ): Response {
        $hand = $session->get('hand');
        $deck = $session->get('deck');
        $points = $session->get('points');
        $game21 = $session->get('game21');
        $gameOver = $session->get('game_over');
        $num = 1;
        $deck->draw($num);
        $new = $deck->getDrawn();
        $hand = array_merge($hand, $new);
        $points = $game21->getPlayerPoints($hand);
        $session->set('hand', $hand);
        $session->set('points', $points);
        if ($points > 21) {
            $this->addFlash(
                'warning',
                'Du förlorade'
            );
            $game21->gameOver();
        }
        $data = [
            'hand' => $hand,
            'points' => $points,
            'bank' => [],
            'bankPoints' => 0,
            'gameOver' => $game21->endGame(),
        ];

        return $this->render('21_game/play.html.twig', $data);
    }

    #[Route('/game/stay', name: 'stand')]
    public function stay(
        SessionInterface $session,
    ): Response {
        $hand = $session->get('hand');
        $deck = $session->get('deck');
        $points = $session->get('points');
        $gameOver = $session->get('game_over');
        $game21 = $session->get('game21');
        $bank = [];
        $bankPoints = 0;
        $test = 1;
        while ($bankPoints < $points && $bankPoints < 17) {
            $num = 1;
            $deck->draw($num);
            $new = $deck->getDrawn();
            $bank = array_merge($bank, $new);
            $bankPoints = $game21->getBankPoints($bank);
        }
        if ($bankPoints < 22 && $bankPoints >= $points) {
            $this->addFlash(
                'warning',
                'Du förlorade'
            );
            $game21->gameOver();
        } else {
            $this->addFlash(
                'win',
                'Du vann!'
            );
            $game21->gameOver();
        }
        $data = [
            'hand' => $hand,
            'points' => $points,
            'bank' => $bank,
            'bankPoints' => $bankPoints,
            'gameOver' => $game21->endGame(),
        ];
        $session->set('hand', $hand);
        $session->set('points', $points);
        $session->set('bankPoints', $bankPoints);
        $session->set('bank', $bank);

        return $this->render('21_game/play.html.twig', $data);
    }
}

<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\game_21\Card21Game;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class Card21Controller extends AbstractController
{

    #[Route('/game/play', name: 'getCards')]
    public function getCards(
        SessionInterface $session,
    ): Response {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $game21 = new Card21Game();
        $session->set('deck', $deck);
        $session->set('game21', $game21);
        $num = 1;
        $deck->draw($num);
        $points = $game21->getPlayerPoints($deck->getDrawn());
        $session->set('hand', $deck->getDrawn());
        $session->set('points', $points);
        $data = [
            'hand' => $deck->getDrawn(),
            'points' => $points,
            'bank' => [],
            'bankPoints' => 0,
            'gameOver' => $game21->endGame(),
        ];

        return $this->render('21_game/play.html.twig', $data);
    }

    #[Route('/game/draw', name: 'drawCards')]
    public function drawCards(
        SessionInterface $session,
    ): Response {
        /** @var string[] $hand */
        $hand = $session->get('hand');
        /** @var DeckOfCards $deck */
        $deck = $session->get('deck');
        /** @var Card21Game $game21 */
        $game21 = $session->get('game21');
        $num = 1;
        $deck->draw($num);
        /** @var string[] $new */
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
        /** @var DeckOfCards $deck */
        $deck = $session->get('deck');
        $points = $session->get('points');
        /** @var Card21Game $game21 */
        $game21 = $session->get('game21');
        $bank = [];
        $bankPoints = $game21->getBankPoints($bank);
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
        }
        if ($bankPoints >= 22 || $bankPoints < $points) {
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

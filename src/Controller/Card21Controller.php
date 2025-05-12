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
        $game_over = false;
        $session->set('deck', $deck);
        $num = 1;
        $points = 0;
        $deck->draw($num);
        // var_dump($deck);
        foreach ($deck->getDrawn() as $card) {
            $cardValue = substr($card, 1, strpos($card, ']') - 1);
            if ($cardValue == 'J') {
                $points +=11;
            } elseif ($cardValue == 'Q') {
                $points +=12;
            } elseif ($cardValue == 'K') {
                $points +=13;
            } elseif ($cardValue == 'A') {
                $points +=14;
            } else {
                $points += (int)$cardValue;
            };
        };
        $data = [
            'hand' => $deck->getDrawn(),
            'points' => $points,
            'bank' => [],
            'bankPoints' => 0,
            'game_over' => $game_over,
        ];
        $session->set('hand', $deck->getDrawn());
        $session->set('points', $points);
        $session->set('game_over', $game_over);

        return $this->render('21_game/play.html.twig', $data);
    }
    #[Route('/21/draw', name: 'draw_card')]
    public function draw_card(
        Request $request,
        SessionInterface $session,
    ): Response {
        $hand = $session->get('hand');
        $deck = $session->get('deck');
        $points = $session->get('points');
        $game_over = $session->get('game_over');
        $num = 1;
        $deck->draw($num);
        $new = $deck->getDrawn();
        $hand = array_merge($hand,$new);
        $card = end($hand);
        $cardValue = substr($card, 1, strpos($card, ']') - 1);
        if ($cardValue == 'J') {
            $points +=11;
        } elseif ($cardValue == 'Q') {
            $points +=12;
        } elseif ($cardValue == 'K') {
            $points +=13;
        } elseif ($cardValue == 'A') {
            $check = 0;
            $check = $points;
            if ($check + 14 > 21) {
                $points += 1;
            } else {
            $points +=14;
            }
        } else {
            $points += (int)$cardValue;
        };
        if ($points > 21) {
            $this->addFlash(
                'warning',
                'Du förlorade'
            );
        }
        $data = [
            'hand' => $hand,
            'points' => $points,
            'bank' => [],
            'bankPoints' => 0,
            'game_over' => $game_over,

        ];
        $session->set('hand', $hand);
        $session->set('points', $points);

        return $this->render('21_game/play.html.twig', $data);
    }
    #[Route('/21/stay', name: 'stand')]
    public function stay(
        Request $request,
        SessionInterface $session,
    ): Response {
        $hand = $session->get('hand');
        $deck = $session->get('deck');
        $points = $session->get('points');
        $game_over = $session->get('game_over');
        $bank = [];
        $bankPoints = 0;
        $test = 1;
        while ($bankPoints < $points && $bankPoints < 17) {
        // while ($test < 4) {
            $num = 1;
            $deck->draw($num);
            $new = $deck->getDrawn();
            $bank = array_merge($bank,$new);
            $card = end($bank);
            $cardValue = substr($card, 1, strpos($card, ']') - 1);
            if ($cardValue == 'J') {
            $bankPoints +=11;
            } elseif ($cardValue == 'Q') {
                $bankPoints +=12;
            } elseif ($cardValue == 'K') {
                $bankPoints +=13;
            } elseif ($cardValue == 'A') {
                $check = 0;
                $check = $bankPoints;
                if ($check + 14 > 21) {
                    $bankPoints += 1;
                } else {
                    $bankPoints +=14;
                }
            } else {
                $bankPoints += (int)$cardValue;
            };
            $test +=1;
        };
        if ($bankPoints < 22 && $bankPoints >= $points) {
            $this->addFlash(
                'warning',
                'Du förlorade'
            );
            $gameOver = true;
        } else {
            $this->addFlash(
                'win',
                'Du vann!'
            );
            $gameOver = true;
        }
        $data = [
            'hand' => $hand,
            'points' => $points,
            'bank' => $bank,
            'bankPoints' => $bankPoints,
            'game_over' => $game_over,
        ];
        $session->set('hand', $hand);
        $session->set('points', $points);
        $session->set('bankPoints', $bankPoints);
        $session->set('bank', $bank);

        return $this->render('21_game/play.html.twig', $data);
    }
}
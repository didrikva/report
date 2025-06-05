<?php

namespace App\Controller;

use App\BlackJack\BlackJackDeck;
use App\BlackJack\BlackJack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BlackJackControllerEnd extends AbstractController
{
    #[Route('/proj/blackJack', name: 'projBankBlackJack')]
    public function projBlackJack(
        SessionInterface $session,
    ): Response {
        $betId = $session->get('betId');
        $name = $session->get('name');
        $cardArray = $session->get('cardArray');
        $placedBet = $session->get('placedBet');
        $amountBet = $session->get('amountBet');
        $chipsLeft = $session->get('chipsLeft');
        $blackJack = $session->get('blackJack');
        $bankCard = $session->get('bankCard');
        $buttonDisable = $session->get('buttonDisable');
        $points = $session->get('points');
        $deck = $session->get('deck');
        $bankPoints = $session->get('bankPoints');
        $this->addFlash(
            'blackjack',
            'Banken fick Black Jack, du förlorade!'
        );
        $data = [
            'placedBet' => $placedBet,
            'betId' => $betId,
            'amountBet' => $amountBet,
            'chipsLeft' => $chipsLeft,
            'hand' => $cardArray,
            'buttonDisable' => $buttonDisable,
            'points' => $points,
            'bankCard' => $bankCard,
            'bankPoints' => $bankPoints,
            'name' => $name,
        ];
        $session->set('cardArray', $cardArray);
        $session->set('deck', $deck);
        $session->set('buttonDisable', $buttonDisable);
        $session->set('points', $points);
        $session->set('bankCard', $bankCard);
        return $this->render('blackjack/end.html.twig', $data);
    }
    #[Route('/proj/gameover', name: 'projGameOver')]
    public function gameover(
        SessionInterface $session,
    ): Response {
        $winner = [];
        $winBet = 0;
        $name = $session->get('name');
        $betId = $session->get('betId');
        $cardArray = $session->get('cardArray');
        $placedBet = $session->get('placedBet');
        $amountBet = $session->get('amountBet');
        $chipsLeft = $session->get('chipsLeft');
        $blackJack = $session->get('blackJack');
        $bankCard = $session->get('bankCard');
        $buttonDisable = $session->get('buttonDisable');
        $points = $session->get('points');
        $deck = $session->get('deck');
        $bankPoints = $session->get('bankPoints');
        while ($bankPoints < 17 && !($bankPoints > max($points))) {
            $num = 1;
            $deck->draw($num);
            $new = $deck->getDrawn();
            $bankCard = array_merge($bankCard, $new);
            $bankPoints = $blackJack->getBankPoints($bankCard);
        }
        foreach ($points as $p) {
            if ($bankPoints < 22) {
                if ($p > $bankPoints && $p < 22) {
                    $winner[] = "win";
                } else {
                    $winner[] = "lose";
                }
            } elseif ($p == 0) {
                $winner[] = "lose";
            } elseif ($p < 22) {
                $winner[] = "win";
            } else {
                $winner[] = "lose";
            }
        }
        for ($i = 0; $i < 3; $i++) {
            if ($winner[$i] == "win") {
                $winBet += $amountBet[$i]*2;
            }
        }
        $chipsLeft = $chipsLeft + $winBet;
        $this->addFlash(
            'win',
            "Grattis {$name}! Du vann {$winBet} spelchips!"
        );
        $data = [
            'placedBet' => $placedBet,
            'betId' => $betId,
            'amountBet' => $amountBet,
            'chipsLeft' => $chipsLeft,
            'hand' => $cardArray,
            'buttonDisable' => $buttonDisable,
            'points' => $points,
            'bankCard' => $bankCard,
            'bankPoints' => $bankPoints,
            'name' => $name,
        ];
        $session->set('cardArray', $cardArray);
        $session->set('deck', $deck);
        $session->set('buttonDisable', $buttonDisable);
        $session->set('points', $points);
        $session->set('bankCard', $bankCard);
        $session->set('chipsLeft', $chipsLeft);
        return $this->render('blackjack/end.html.twig', $data);
    }
}

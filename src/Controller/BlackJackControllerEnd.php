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
        var_dump($bankPoints);
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
        ];
        $session->set('cardArray', $cardArray);
        $session->set('deck', $deck);
        $session->set('buttonDisable', $buttonDisable);
        $session->set('points', $points);
        $session->set('bankCard', $bankCard);
        return $this->render('blackjack/end.html.twig', $data);
    }
}

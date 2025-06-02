<?php

namespace App\Controller;

use App\BlackJack\BlackJackDeck;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BlackJackController extends AbstractController
{
    #[Route('/proj/cards', name: 'projGetCard')]
    public function proj(
        SessionInterface $session,
    ): Response {
        $betId = $session->get('betId');
        $placedBet = $session->get('placedBet');
        $amountBet = $session->get('amountBet');
        $chipsLeft = $session->get('chipsLeft');
        
        $deck = new BlackJackDeck();
        $deck->shuffle();
        $num = 6;
        $deck->draw($num);
        // var_dump($deck);
        
        $data = [
            'placedBet' => $placedBet,
            'betId' => $betId,
            'amountBet' => $amountBet,
            'chipsLeft' => $chipsLeft,
            'hand' => $deck->getDrawn(),
        ];
        return $this->render('blackjack/game.html.twig', $data);
    }
}

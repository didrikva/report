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
        $cardArray = [[], [], []];
        $betId = $session->get('betId');
        $placedBet = $session->get('placedBet');
        $amountBet = $session->get('amountBet');
        $chipsLeft = $session->get('chipsLeft');
        
        $deck = new BlackJackDeck();
        $deck->shuffle();
        $num = 2;
        for ($i = 0; $i < count($betId); $i++) {
            $deck->draw($num);
            $cardArray[$betId[$i] - 1] = $deck->getDrawn();
            var_dump($betId[$i]);
        }
        var_dump($betId);
        
        $data = [
            'placedBet' => $placedBet,
            'betId' => $betId,
            'amountBet' => $amountBet,
            'chipsLeft' => $chipsLeft,
            'hand' => $cardArray,
        ];
        return $this->render('blackjack/game.html.twig', $data);
    }
}

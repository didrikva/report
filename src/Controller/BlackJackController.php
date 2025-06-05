<?php

namespace App\Controller;

use App\BlackJack\BlackJackDeck;
use App\BlackJack\BlackJack;
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
        $bankCard = [];
        $buttonDisable = [];
        $points = [0, 0, 0];
        $betId = $session->get('betId');
        sort($betId);
        $placedBet = $session->get('placedBet');
        $amountBet = $session->get('amountBet');
        $chipsLeft = $session->get('chipsLeft');
        $deck = new BlackJackDeck();
        $blackJack = new BlackJack();
        $session->set('blackJack', $blackJack);
        $deck->shuffle();
        $num = 2;
        for ($i = 0; $i < count($betId); $i++) {
            $deck->draw($num);
            $cardArray[$betId[$i] - 1] = $deck->getDrawn();
            $points[$betId[$i]- 1] = $blackJack->getPlayerPoints($cardArray[$betId[$i] - 1]);
        }
        $deck->draw($num);
        $bankCard = $deck->getDrawn();
        $session->set('bankPoints', $blackJack->getBankPoints($bankCard));
        $session->set('bankCard', $bankCard);
        if ($blackJack->getBankPoints($bankCard) == 21) {
            return $this->redirectToRoute('projBankBlackJack');
        }
        $data = [
            'placedBet' => $placedBet,
            'betId' => $betId,
            'amountBet' => $amountBet,
            'chipsLeft' => $chipsLeft,
            'hand' => $cardArray,
            'buttonDisable' => $buttonDisable,
            'points' => $points,
            'bankCard' => $bankCard,
        ];
        $session->set('cardArray', $cardArray);
        $session->set('deck', $deck);
        $session->set('buttonDisable', $buttonDisable);
        $session->set('points', $points);
        return $this->render('blackjack/game.html.twig', $data);
    }
    #[Route('/proj/draw/{id}', name: 'projDrawCard')]
    public function projDraw(
        SessionInterface $session,
        int $id,
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
        $num = 1;
        $deck->draw($num);
        $card = $deck->getDrawn();
        $cardArray[$id - 1][] = $card[0];
        $points[$id-1] = $blackJack->getPlayerPoints($cardArray[$id-1]);
        if ($points[$id-1] > 21) {
            $buttonDisable[] = $id;
            $session->set('points', $points);
            $session->set('cardArray', $cardArray);
        };
        if (count($buttonDisable) == count($betId)) {
            return $this->redirectToRoute('projGameOver');
        }
        $data = [
            'placedBet' => $placedBet,
            'betId' => $betId,
            'amountBet' => $amountBet,
            'chipsLeft' => $chipsLeft,
            'hand' => $cardArray,
            'buttonDisable' => $buttonDisable,
            'points' => $points,
            'bankCard' => $bankCard,
        ];
        $session->set('cardArray', $cardArray);
        $session->set('deck', $deck);
        $session->set('points', $points);
        $session->set('buttonDisable', $buttonDisable);
        return $this->render('blackjack/game.html.twig', $data);
    }
    #[Route('/proj/stay/{id}', name: 'projStay')]
    public function projstay(
        SessionInterface $session,
        int $id,
    ): Response {
        $betId = $session->get('betId');
        $cardArray = $session->get('cardArray');
        $bankCard = $session->get('bankCard');
        $placedBet = $session->get('placedBet');
        $amountBet = $session->get('amountBet');
        $chipsLeft = $session->get('chipsLeft');
        $buttonDisable = $session->get('buttonDisable');
        $points = $session->get('points');
        $deck = $session->get('deck');
        if (!in_array($id, $buttonDisable)) {
            $buttonDisable[] = $id;
        };
        if (count($buttonDisable) == count($betId)) {
            return $this->redirectToRoute('projGameOver');
        }
        $data = [
            'placedBet' => $placedBet,
            'betId' => $betId,
            'amountBet' => $amountBet,
            'chipsLeft' => $chipsLeft,
            'hand' => $cardArray,
            'buttonDisable' => $buttonDisable,
            'points' => $points,
            'bankCard' => $bankCard,
        ];
        $session->set('cardArray', $cardArray);
        $session->set('deck', $deck);
        $session->set('buttonDisable', $buttonDisable);
        return $this->render('blackjack/game.html.twig', $data);
    }
}

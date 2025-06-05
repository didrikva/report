<?php

namespace App\Controller;

use App\BlackJack\BlackJackDeck;
use App\BlackJack\BlackJack;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BlackJackControllerAPI extends AbstractController
{
    #[Route('/proj/api', name: 'projApi')]
    public function proj(
        SessionInterface $session,
    ): Response {
        return $this->render('blackjack/api.html.twig');
    }
    #[Route('/proj/api/balance', name: 'projShowBalance')]
    public function projBalance(
        SessionInterface $session,
    ): JSONResponse {
        $chipsLeft = $session->get('chipsLeft');
        $name = $session->get('name');
        $response = new JsonResponse([
            'spelare' => $name,
            'balance' => $chipsLeft]);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route('/proj/api/cards', name: 'projShowCards')]
    public function projCards(
        SessionInterface $session,
    ): JSONResponse {
        $handPoints = [[],[],[]];
        $cardArray = $session->get('cardArray');
        $points = $session->get('points');
        $chipsLeft = $session->get('chipsLeft');
        $name = $session->get('name');
        for ($i=0; $i <3; $i++) {
            if ($points[$i] !== 0) {
                $handPoints[$i] = [
                'cards' => $cardArray[$i],
                'points' => $points[$i]];
            }
        }
        $response = new JsonResponse([
            'spelare' => $name,
            'handPoints' => $handPoints]);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route('/proj/api/winnings', name: 'projWinnings')]
    public function projWin(
        SessionInterface $session,
    ): JSONResponse {
        $winBet = $session->get('winBet');
        $name = $session->get('name');
        $response = new JsonResponse([
            'spelare' => $name,
            'vinst' => $winBet]);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
    #[Route('/proj/api/deposit/{amount}', name: 'projDepositPost', methods: ['POST', 'GET'])]
    public function projDepositPost(
        SessionInterface $session,
        int $amount,
    ): Response {
        $chipsLeft = $session->get('chipsLeft');
        $chipsLeft += $amount;
        $session->set('chipsLeft', $chipsLeft);

        return $this->redirectToRoute('projShowBalance');
    }
    #[Route('/proj/api/quickPLay/{bet}', name: 'projQuickPlay')]
    public function projQuickPLay(
        SessionInterface $session,
        int $bet,
    ): Response {
        $points = 0;
        $bankPoints = 0;
        $cards = [];
        $bankcards = [];
        $result = "";
        $chipsLeft = $session->get('chipsLeft');
        $deck = new BlackJackDeck();
        $blackJack = new BlackJack();
        $deck->shuffle();
        while ($points < 16) {
            $num = 1;
            $deck->draw($num);
            $new = $deck->getDrawn();
            $cards = array_merge($cards, $new);
            $points = $blackJack->getPlayerPoints($cards);
        }
        while ($bankPoints <= 17) {
            $num = 1;
            $deck->draw($num);
            $new = $deck->getDrawn();
            $bankcards = array_merge($bankcards, $new);
            $bankPoints = $blackJack->getBankPoints($bankcards);
        }
        if (($points <= 21 && $bankPoints > 21) || ($points > $bankPoints && $points <= 21)) {
            $result = "You won 20 chips";
            $chipsLeft += 20;
            $session->set('chipsLeft', $chipsLeft);
        } else {
            $result = "You lost";
            $chipsLeft -= 10;
            $session->set('chipsLeft', $chipsLeft);

        }
        $chipsLeft = $session->get('chipsLeft');
        $response = new JsonResponse([
            'cards' => $cards,
            'points' => $points,
            'bankcards' => $bankcards,
            'bankpoints' => $bankPoints, 
            'resultat' => $result,
            'balance' => $chipsLeft]);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}

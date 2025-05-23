<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class LuckyControllerTwig extends AbstractController
{
    #[Route('/api/game', name: 'game21api')]
    public function game21(
        SessionInterface $session,
    ): JsonResponse {
        $hand = $session->get('hand');
        $points = $session->get('points');
        $bank = $session->get('bank');
        $bankPoints = $session->get('bankPoints');
        $response = new JsonResponse([
            'hand' => $hand,
            'points' => $points,
            'bank' => $bank,
            'bankPoints' => $bankPoints]);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }

    #[Route('/api/deck', name: 'deck')]
    public function apideck(
        SessionInterface $session,
    ): JsonResponse {
        /** @var DeckOfCards $deckOfCards */
        $deckOfCards = $session->get('card_hand');
        $copy = clone $deckOfCards;
        $copy->sort();
        $hearts = [];
        $diamonds = [];
        $clubs = [];
        $spades = [];

        foreach ($copy->getValue() as $card) {
            $symbol = mb_substr($card, -1, 1, 'UTF-8'); // https://www.php.net/manual/en/function.mb-substr.php

            switch ($symbol) {
                case '♥':
                    $hearts[] = $card;
                    break;
                case '♦':
                    $diamonds[] = $card;
                    break;
                case '♣':
                    $clubs[] = $card;
                    break;
                case '♠':
                    $spades[] = $card;
                    break;
            }
        }
        $deck = array_merge($hearts, $diamonds, $clubs, $spades);
        $response = new JsonResponse([
            'remaining' => $session->get('card_left'),
            'cards' => $deck,
        ]);

        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );

        return $response;
    }

    #[Route('/api/deck/shuffle', name: 'shuffle_card', methods: ['POST', 'GET'])]
    public function apishuffle(
        SessionInterface $session,
    ): JsonResponse {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $session->set('card_hand', $deck);
        $session->set('card_left', count($deck->getValue()));
        $response = new JsonResponse([
            'deck' => $deck->getString()]);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}

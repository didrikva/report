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

class LuckyControllerTwigDraw extends AbstractController
{
    #[Route('/api/deck/draw', name: 'card_init_get', methods: ['GET'])]
    #[Route("/api/deck/draw/{num<\d+>}", name: 'card_init_get_number', methods: ['GET'])]
    public function init(int $num = 1): Response
    {
        return $this->render('card/play/init.html.twig', [
            'number' => $num,
        ]);
    }

    #[Route('/api/deck/draw', name: 'card_init_post', methods: ['POST'])]
    #[Route("/api/deck/draw/{num<\d+>}", name: 'card_init_post_number', methods: ['POST'])]
    public function initCallback(
        Request $request,
        SessionInterface $session,
        ?int $num = null,
    ): Response {
        if (null === $num) {
            $num = (int) $request->request->get('num_cards');
        }
        /** @var DeckOfCards $deckOfCards */
        $deckOfCards = $session->get('card_hand');
        $deckOfCards->draw($num);
        $session->set('number', $num);
        $session->set('drawn_cards', $deckOfCards->getDrawn());
        $session->set('card_hand', $deckOfCards);
        $session->set('card_left', count($deckOfCards->getValue()));

        return $this->redirectToRoute('api_draw_result');
    }

    #[Route('/api/deck/draw/result', name: 'api_draw_result', methods: ['GET'])]
    public function apiDrawNumber(
        SessionInterface $session,
    ): JsonResponse {
        $num = $session->get('number');
        $cardLeft = $session->get('card_left');
        if ($num > 52) {
            throw new Exception('Can not draw more than 52 cards!');
        } elseif ($num > $cardLeft) {
            throw new Exception('Not that many cards left in deck, shuffle!');
        }
        $response = new JsonResponse([
            'number' => $session->get('number'),
            'remaining' => $session->get('card_left'),
            'drawn' => $session->get('drawn_cards')]);

        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );

        return $response;
    }
}

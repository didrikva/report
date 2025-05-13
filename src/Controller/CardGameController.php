<?php

namespace App\Controller;


use App\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route('/session', name: 'card_session')]
    public function initCallback(
        SessionInterface $session,
    ): Response {
        /** @var DeckOfCards|null $deckOfCards */
        $deckOfCards = $session->get('card_hand');
        $cardLeft = $session->get('card_left', 0);
        $deck = '';
        if ($deckOfCards !== null) {
            $deck = $deckOfCards->getString();
        }

        return $this->render('card/session.html.twig', [
            'deck' => $deck,
            'number' => $cardLeft,
        ]);
    }

    #[Route('/session/delete', name: 'card_delete')]
    public function deleteCallback(
        SessionInterface $session,
    ): Response {
        $session->clear();
        /** @var DeckOfCards|null $deckOfCards */
        $deckOfCards = $session->get('card_hand');
        $cardLeft = $session->get('card_left', 0);
        $deck = '';
        if ($deckOfCards !== null) {
            $deck = $deckOfCards->getString();
        }

        return $this->render('card/session.html.twig', [
            'deck' => $deck,
            'number' => $cardLeft,
        ]);
    }

    #[Route('/card', name: 'card_start')]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }

    #[Route('/card/deck/draw', name: 'card_draw')]
    public function draw(
        SessionInterface $session,
    ): Response {
        /** @var DeckOfCards $deckOfCards */
        $deckOfCards = $session->get('card_hand');
        $num = 1;
        $deckOfCards->draw($num);
        $session->set('card_left', count($deckOfCards->getValue()));
        $data = [
            'drawn_card' => $deckOfCards->getDrawn(),
            'amount_left' => $session->get('card_left'),
        ];

        return $this->render('card/play/draw.html.twig', $data);
    }

    #[Route('/card/deck', name: 'card_deck')]
    public function deck(
        SessionInterface $session,
    ): Response {
        /** @var DeckOfCards $deckOfCards */
        $deckOfCards = $session->get('card_hand');
        $copy = clone $deckOfCards;
        $copy->sort();
        $data = [
            'deck' => $copy->getValue(),
        ];

        return $this->render('card/play/deck.html.twig', $data);
    }

    #[Route('/card/deck/shuffle', name: 'card_shuffle')]
    public function shuffle(
        SessionInterface $session,
    ): Response {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $data = [
            'deck' => $deck->getString(),
        ];
        $session->set('card_hand', $deck);
        $session->set('card_left', count($deck->getValue()));

        return $this->render('card/play/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: 'card_draw_number')]
    public function testRollDices(int $num,
        SessionInterface $session,
    ): Response {
        $cardLeft = $session->get('card_left');
        if ($num > 52) {
            throw new Exception('Can not draw more than 52 cards!');
        } elseif ($num > $cardLeft) {
            throw new Exception('Not that many cards left in deck, shuffle!');
        }
        /** @var DeckOfCards $deckOfCards */
        $deckOfCards = $session->get('card_hand');
        $deckOfCards->draw($num);
        $session->set('card_left', count($deckOfCards->getValue()));
        $data = [
            'deck' => $session->get('card_left'),
            'drawn_cards' => $deckOfCards->getDrawn(),
        ];
        $session->set('card_hand', $deckOfCards);

        return $this->render('card/play/draw_num.html.twig', $data);
    }
}

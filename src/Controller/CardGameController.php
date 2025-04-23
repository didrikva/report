<?php

namespace App\Controller;
use App\Controller\Card\CardGraphic;
use App\Controller\Card\Card;
use App\Controller\Card\DeckOfCards;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/session", name: "card_session")]
    public function initCallback(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $session->set("pig_dicehand", 5);
        $dicehand = $session->get("pig_dicehand");

        return $this->render('card/session.html.twig', [
            'dicehand' => $dicehand
        ]);
    }
    #[Route("/session/delete", name: "card_delete")]
    public function deleteCallback(
        Request $request,
        SessionInterface $session
    ): Response
    {
        $session->clear();
        $dicehand = $session->get("pig_dicehand");
        $this->addFlash(
            'warning',
            'Nu är sessionen raderad!'
        );
        return $this->render('card/session.html.twig', [
            'dicehand' => $dicehand
        ]);
    }
    #[Route("/card", name: "card_start")]
    public function home(): Response
    {
        return $this->render('card/home.html.twig');
    }
    #[Route("/card/deck/draw", name: "card_draw")]
    public function draw(
        SessionInterface $session
    ): Response
    {
        $deckOfCards = $session->get("card_hand");
        $cardLeft = $session->get("card_left");
        $session->set("card_left", $cardLeft - 1);
        $card = new Card();
        $card->draw();
        $value = new CardGraphic();
        $data = [
            "draw_card" => $card->getAsString(),
            "draw_value" => $value->getAsString(),
            "amount_left" => $session->get("card_left"),
        ];
        return $this->render('card/play/draw.html.twig', $data);
    }
    #[Route("/card/deck", name: "card_deck")]
    public function deck(): Response
    {
        $deck = new DeckOfCards();
        $data = [
            "deck" => $deck->getString(),
        ];
        return $this->render('card/play/deck.html.twig', $data);
    }
    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function shuffle(
        SessionInterface $session
    ): Response
    {
        $deck = new DeckOfCards();
        $deck->shuffle();
        $data = [
            "deck" => $deck->getString(),
        ];
        $session->set("card_hand", $deck);
        $session->set("card_left", 52);
        return $this->render('card/play/shuffle.html.twig', $data);
    }
    #[Route("/card/deck/draw/{num<\d+>}", name: "card_draw_number")]
    public function testRollDices(int $num,
    SessionInterface $session
    ): Response
    {
        $cardLeft = $session->get("card_left");
        if ($num > 52) {
            throw new \Exception("Can not draw more than 52 cards!");
        } elseif ($num > $cardLeft) {
            throw new \Exception("Not that many cards left in deck, shuffle!");
        };
        $deckOfCards = $session->get("card_hand");
        $session->set("card_left", $cardLeft - $num);
        $deckOfCards->draw($num);
        $data = [
            "deck" => $session->get("card_left"),
            "drawn_cards" => $deckOfCards->getDrawn(),
        ];
        $session->set("card_hand", $deckOfCards);
        return $this->render('card/play/draw_num.html.twig', $data);
    }
}
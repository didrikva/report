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
    public function draw(): Response
    {
        $card = new Card();
        $card->draw();
        $value = new CardGraphic();
        $data = [
            "draw_card" => $card->getAsString(),
            "draw_value" => $value->getAsString(),
            "amount_left" => $card->getAsString(),
        ];
        return $this->render('card/play/draw.html.twig', $data);
    }
    #[Route("/card/deck", name: "card_deck")]
    public function deck(): Response
    {
        $deck = new DeckOfCards();
        $data = [
            "deck" => $deck->getAsString(),
        ];
        return $this->render('card/play/deck.html.twig', $data);
    }
}
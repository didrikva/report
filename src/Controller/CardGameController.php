<?php

namespace App\Controller;
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

        return $this->render('card/home.html.twig', [
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
        return $this->render('card/home.html.twig', [
            'dicehand' => $dicehand
        ]);
    }
}
<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BlackJackControllerStart extends AbstractController
{
    #[Route('/proj', name: 'projHome')]
    public function proj(
    ): Response {
        return $this->render('blackjack/start.html.twig');
    }

    #[Route('/proj/about', name: 'projAbout')]
    public function about(
    ): Response {
        return $this->render('blackjack/about.html.twig');
    }
    #[Route('/proj/start', name: 'projStart')]
    public function play(
        SessionInterface $session,
    ): Response {
        $amountBet = [0, 0, 0];
        $chipsLeft = 100;
        $data = [
            'placedBet' => false,
            'betId' => [],
            'amountBet' => $amountBet,
            'chipsLeft' => $chipsLeft,
            'disabled' => true
        ];
        $session->set('betId', []);
        $session->set('placedBet', false);
        $session->set('amountBet', $amountBet);
        $session->set('chipsLeft', $chipsLeft);
        return $this->render('blackjack/play.html.twig', $data);
    }
    #[Route('/proj/bet/{id}/{bet}', name: 'projBet')]
    public function betGET(
        int $id,
        int $bet,
        SessionInterface $session,
    ): Response {
        $disabled = true;
        $betId = $session->get('betId');
        $placedBet = $session->get('placedBet');
        $amountBet = $session->get('amountBet');
        $chipsLeft = $session->get('chipsLeft');
        $chipsLeft -= $bet;
        if ($chipsLeft == 0) {
            $disabled = false;
        }
        $amountBet[$id-1] += $bet;
        $placedBet = True;
        $betId[] = $id;
        $data = [
            'placedBet' => $placedBet,
            'betId' => $betId,
            'amountBet' => $amountBet,
            'chipsLeft' => $chipsLeft,
            'disabled' => $disabled
        ];
        $session->set('betId', $betId);
        $session->set('amountBet', $amountBet);
        $session->set('chipsLeft', $chipsLeft);
        return $this->render('blackjack/play.html.twig', $data);
    }
}

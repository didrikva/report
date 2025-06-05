<?php

namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class BlackJackControllerStart extends AbstractController
{
    #[Route('/proj', name: 'projHome')]
    public function proj(
    ): Response {
        return $this->render('blackjack/start.html.twig');
    }
    #[Route('/proj/session', name: 'projSession')]
    public function projSession(
        SessionInterface $session,
    ): Response {
        $session->clear();
        $this->addFlash(
            'warning',
            'Sessionen rensad'
        );
        return $this->render('blackjack/start.html.twig');
    }

    #[Route('/proj/about', name: 'projAbout')]
    public function about(
    ): Response {
        return $this->render('blackjack/about.html.twig');
    }
    #[Route('/proj/name', name: 'projNameGet', methods: ['GET'])]
    public function name(
    ): Response {
        return $this->render('blackjack/name.html.twig');
    }
    #[Route('/proj/name', name: 'projNamePost', methods: ['POST'])]
    public function namePost(
        Request $request,
        SessionInterface $session,
    ): Response {
        $name = $request->request->get('player_name');
        $session->set('name', $name);
        return $this->redirectToRoute('projStart');
    }
    #[Route('/proj/start', name: 'projStart')]
    public function play(
        SessionInterface $session,
    ): Response {
        $name = $session->get('name');
        $amountBet = [0, 0, 0];
        $disabled = true;
        $chipsLeft = $session->get('chipsLeft');
        if ($chipsLeft === null) {
            $chipsLeft = 100;
        }
        if ($chipsLeft <= 0) {
            $disabled = false;
        }
        $data = [
            'placedBet' => false,
            'betId' => [],
            'amountBet' => $amountBet,
            'chipsLeft' => $chipsLeft,
            'disabled' => $disabled,
            'name' => $name
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
        $name = $session->get('name');
        $betId = $session->get('betId');
        $placedBet = $session->get('placedBet');
        $amountBet = $session->get('amountBet');
        $chipsLeft = $session->get('chipsLeft');
        $chipsLeft -= $bet;
        if ($chipsLeft <= 0) {
            $disabled = false;
        }
        $amountBet[$id-1] += $bet;
        $placedBet = True;
        if (!in_array($id, $betId)) {
            $betId[] = $id;
        };

        $data = [
            'placedBet' => $placedBet,
            'betId' => $betId,
            'amountBet' => $amountBet,
            'chipsLeft' => $chipsLeft,
            'disabled' => $disabled,
            'name' => $name
        ];
        $session->set('betId', $betId);
        $session->set('amountBet', $amountBet);
        $session->set('chipsLeft', $chipsLeft);
        return $this->render('blackjack/play.html.twig', $data);
    }
}

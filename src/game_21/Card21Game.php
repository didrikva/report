<?php

namespace App\game_21;

class Card21Game
{
    private array $hand = [];
    private array $bankHand = [];
    private bool $gameOver = false;

    public function __construct()
    {
    }

    public function setDeck($deck): void
    {
        $this->deck = $deck;
    }

    public function getPlayerPoints(array $hand): int
    {
        $this->hand = $hand;

        return $this->calcPoints($this->hand);
    }

    public function getBankPoints(array $bank): int
    {
        $this->bankHand = $bank;

        return $this->calcPoints($this->bankHand);
    }

    private function calcPoints(array $hand): int
    {
        $points = 0;
        $ess = [];
        foreach ($hand as $card) {
            $cardValue = substr($card, 1, strpos($card, ']') - 1);
            if ('J' === $cardValue) {
                $points += 11;
            } elseif ('Q' === $cardValue) {
                $points += 12;
            } elseif ('K' === $cardValue) {
                $points += 13;
            } elseif ('A' === $cardValue) {
                $ess[] = $cardValue;
            } elseif (is_numeric($cardValue)) {
                $points += (int) $cardValue;
            }
        }
        $points = $this->checkEss($ess, $points);

        return $points;
    }
    private function checkEss(array $ess, int $points): int
    {
        $essCount = count($ess);

        for ($i = 0; $i < $essCount; $i++) {
            $points += ($points + 14 > 21) ? 1 : 14;
        }

        return $points;
    }

    public function endGame(): bool
    {
        return $this->gameOver;
    }

    public function gameOver(): void
    {
        $this->gameOver = true;
    }
}

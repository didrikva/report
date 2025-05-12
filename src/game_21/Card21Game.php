<?php

namespace App\game_21;

class Card21Game
{
    private array $playerHand = [];
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
            } else {
                $points += (int) $cardValue;
            }
        }
        foreach ($ess as $card) {
            if ('A' === $card) {
                if ($points + 14 > 21) {
                    ++$points;
                } else {
                    $points += 14;
                }
            }
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

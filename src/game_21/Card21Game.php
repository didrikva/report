<?php

namespace App\game_21;

/**
 * Class for the card game 21.
 */
class Card21Game
{
    /**
     * @var string[]
     */
    private array $hand = [];
    /** @var string[] */
    private array $bankHand = [];
    private bool $gameOver = false;
    /** @var string[] */
    private array $deck = [];

    /**
     * constructor.
     */
    public function __construct()
    {
    }

    /**
     * Set the given deck.
     *
     * @param string[] $deck
     */
    public function setDeck(array $deck): void
    {
        $this->deck = $deck;
    }

    /**
     * Calculates and returns the players points.
     *
     * @param string[] $hand
     */
    public function getPlayerPoints(array $hand): int
    {
        $this->hand = $hand;

        return $this->calcPoints($this->hand);
    }

    /**
     * Calculates and returns the banks points.
     *
     * @param string[] $bank
     */
    public function getBankPoints(array $bank): int
    {
        $this->bankHand = $bank;

        return $this->calcPoints($this->bankHand);
    }

    /**
     * Calculates the points for the given hand.
     *
     * @param string[] $hand
     */
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

    /**
     * Function to calculate if a ess is worth 1 or 14 points.
     *
     * @param string[] $ess
     */
    private function checkEss(array $ess, int $points): int
    {
        $essCount = count($ess);

        for ($i = 0; $i < $essCount; ++$i) {
            if ($points + 14 > 21) {
                ++$points;
                continue;
            }
            $points += 14;
        }

        return $points;
    }

    /**
     * Checks if the game is still playing.
     */
    public function endGame(): bool
    {
        return $this->gameOver;
    }

    /**
     * Function that ends the game.
     */
    public function gameOver(): void
    {
        $this->gameOver = true;
    }
}

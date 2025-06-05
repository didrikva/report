<?php

namespace App\BlackJack;
use Exception;

/**
 * Class for the black jack game
 */
class BlackJack
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
            if(strlen($card) !== 1) {
                $cardValue = mb_substr($card, 0, -1);
                if (is_numeric($cardValue)) {
                    $points += (int) $cardValue;
                } elseif ('A' === $cardValue) {
                    $ess[] = $cardValue;
                } else {
                    $points += 10;
                }
            } else {
                throw new Exception("To short value");
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
            if ($points + 11 > 21) {
                ++$points;
                continue;
            }
            $points += 11;
        }

        return $points;
    }
}

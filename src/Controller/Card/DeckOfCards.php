<?php

namespace App\Controller\DeckOfCards;

use App\Card\Card;
use App\Card\CardGraphic;

class DeckOfCards
{

    protected $cards = [];

    public function __construct()
    {
        for ($i = 0; $i < 4; $i++) {
            for ($j = 0; $j < 13; $j++) {
                $card = new Card($j + 1);
                $value = new CardGraphic($i + 1);
                $this->cards[] = $card->getAsString() . $value->getAsString();
            }
        }
    }

    public function getAsString(): string
    {
        return "[{$this->cards}]";
    }
}
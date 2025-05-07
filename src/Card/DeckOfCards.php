<?php

namespace App\Card;

class DeckOfCards
{
    protected $cards = [];
    protected $draw_cards = [];

    public function __construct()
    {
        for ($i = 0; $i < 4; ++$i) {
            for ($j = 0; $j < 13; ++$j) {
                $card = new Card();
                $card->getValue($j);
                $value = new CardGraphic();
                $this->cards[] = $card->getAsString().$value->getString($i);
            }
        }
    }

    public function getAsString(): string
    {
        return "[{$this->cards}]";
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card;
        }

        return $values;
    }

    public function shuffle(): array
    {
        shuffle($this->cards);

        return $this->cards;
    }

    public function draw($num): void
    {
        $this->draw_cards = array_slice($this->cards, 0, $num);
        $this->cards = array_slice($this->cards, $num);
    }

    public function getDrawn(): array
    {
        return $this->draw_cards;
    }

    public function getValue(): array
    {
        return $this->cards;
    }
    public function sort(): array
    {
        
        $number = [];
        $rest = [];
        foreach ($this->cards as $card) {
            $cardValue = substr($card, 1, strpos($card, ']') - 1);
    
            if (is_numeric($cardValue) && $cardValue != 10) {
                $number[] = $card;
            } else {
                $rest[] = $card;
            }
            
        }
        $order = ['10', 'J', 'Q', 'K', 'A'];
        $sorted = [];

        foreach ($order as $i) {
            foreach ($rest as $card) {
                $value = substr($card, 1, strpos($card, ']') - 1);
                if ($value === $i) {
                    $sorted[] = $card;
                }
            }
        }
        sort($number);
        
        // var_dump($rest);
        // var_dump($number);
        $this->cards = array_merge($number, $sorted);
        // var_dump($this->cards);
        return $this->cards;
        
    }
}

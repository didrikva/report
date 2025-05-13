<?php

namespace App\Card;

class DeckOfCards
{
    /** @var string[] */
    protected array $cards = [];
    /** @var string[] */
    protected array $drawCards = [];

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
    /**
    * @return string[]
    */
    public function getString(): array
    {
        $values = [];
        foreach ($this->cards as $card) {
            $values[] = $card;
        }

        return $values;
    }

    /**
    * @return string[]
    */
    public function shuffle(): array
    {
        shuffle($this->cards);

        return $this->cards;
    }

    public function draw(int $num): void
    {
        $this->drawCards = array_slice($this->cards, 0, $num);
        $this->cards = array_slice($this->cards, $num);
    }

    /**
     * @return string[]
     */
    public function getDrawn(): array
    {
        return $this->drawCards;
    }
    /**
     * @return string[]
     */
    public function getValue(): array
    {
        return $this->cards;
    }
    /**
     * @return string[]
     */
    public function sort(): array
    {
        $number = [];
        $rest = [];
        foreach ($this->cards as $card) {
            $cardValue = substr($card, 1, strpos($card, ']') - 1);

            if (is_numeric($cardValue) && 10 != $cardValue) {
                $number[] = $card;
            }

            $rest[] = $card;
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

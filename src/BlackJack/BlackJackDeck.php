<?php

namespace App\BlackJack;

/**
 * Class that creates the deck with both the card and graphic cards.
 */
class BlackJackDeck
{
    /** @var string[] */
    protected array $cards = [];
    /** @var string[] */
    protected array $drawCards = [];

    /**
     * The constructor that creates a new deck.
     */
    public function __construct()
    {
        for ($i = 0; $i < 4; ++$i) {
            for ($j = 0; $j < 13; ++$j) {
                $card = new BlackJackCard();
                $card->getValue($j);
                $value = new BlackJackGraphic();
                $this->cards[] = $card->getAsString().$value->getString($i);
            }
        }
    }

    /**
     * Get the string from the deck.
     *
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
     * shuffle the deck.
     *
     * @return string[]
     */
    public function shuffle(): array
    {
        shuffle($this->cards);

        return $this->cards;
    }

    /**
     * draw cards from the deck, split the deck into drawn cards and the rest.
     */
    public function draw(int $num): void
    {
        $this->drawCards = array_slice($this->cards, 0, $num);
        $this->cards = array_slice($this->cards, $num);
    }

    /**
     * get the drawn cards.
     *
     * @return string[]
     */
    public function getDrawn(): array
    {
        return $this->drawCards;
    }

    /**
     * Get the rest of the deck.
     *
     * @return string[]
     */
    public function getValue(): array
    {
        return $this->cards;
    }

}

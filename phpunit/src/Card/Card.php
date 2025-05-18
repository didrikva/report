<?php

namespace Didrik\Card;

/**
 * Class that creates the value of the cards.
 */
class Card
{
    protected string $value;
    /**
     * @var non-empty-array<int, string>
     */
    protected array $cards = [
        '2', '3', '4', '5', '6', '7', '8', '9', '10',
        'J', 'Q', 'K', 'A',
    ];

    /**
     * Initializes the card with an empty value.
     */
    public function __construct()
    {
        $this->value = '';
    }

    /**
     * Draw a random card som the given values.
     */
    public function draw(): string
    {
        $this->value = $this->cards[random_int(0, count($this->cards) - 1)];

        return $this->value;
    }

    /**
     * Get the value from the cards.
     */
    public function getValue(int $num): string
    {
        $this->value = $this->cards[$num];

        return $this->value;
    }

    /**
     * Get the string vaklue of the card.
     */
    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}

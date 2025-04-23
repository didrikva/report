<?php

namespace App\Controller\Card;


class Card
{
    protected $value;

    protected array $cards = [
        '2', '3', '4', '5', '6', '7', '8', '9', '10',
        'J', 'Q', 'K', 'A'
    ];

    public function __construct()
    {
        $this->value = null;
    }

    public function draw(): string
    {
        $this->value = $this->cards[random_int(0, count($this->cards) - 1)];
        return $this->value;
    }

    public function getValue($num): string
    {
        $this->value = $this->cards[$num];
        return $this->value;
    }

    public function getAsString(): string
    {
        return "[{$this->value}]";
    }
}
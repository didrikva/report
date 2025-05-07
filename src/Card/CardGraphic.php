<?php

namespace App\Card;

class CardGraphic extends Card
{
    private $representation = [
        '♥',
        '♦',
        '♣',
        '♠',
    ];

    public function __construct()
    {
        parent::__construct();
        $this->value = random_int(0, 3);
    }

    public function getValue($num): string
    {
        $this->value = $this->representation[$num];

        return $this->value;
    }

    public function getString($num): string
    {
        return $this->representation[$num];
    }

    public function getAsString(): string
    {
        return $this->representation[$this->value];
    }
}

<?php

namespace App\Controller\Card;

class CardGraphic extends Card
{
    private $representation = [
        '♠',
        '♥',
        '♦',
        '♣'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->value = random_int(0, 3);
    }

    public function getAsString(): string
    {
        return $this->representation[$this->value];
    }
}
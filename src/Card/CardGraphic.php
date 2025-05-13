<?php

namespace App\Card;

class CardGraphic extends Card
{
    /** @var string[] */
    private array $representation = [
        '♥',
        '♦',
        '♣',
        '♠',
    ];
    protected string $value;

    public function __construct()
    {
        parent::__construct();
    }

    public function getValue(int $num): string
    {
        $this->value = $this->representation[$num];

        return $this->value;
    }

    public function getString(int $num): string
    {
        return $this->representation[$num];
    }

    public function getAsString(): string
    {
        return $this->representation[$this->value];
    }
}

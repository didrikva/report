<?php

namespace App\BlackJack;

/**
 * Class that creates the graphic of the card.
 */
class BlackJackGraphic extends BlackJackCard
{
    /** @var string[] */
    private array $representation = [
        '♥',
        '♦',
        '♣',
        '♠',
    ];
    protected string $value;

    /**
     * Construktor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Get the value from the graphic.
     */
    public function getValue(int $num): string
    {
        $this->value = $this->representation[$num];

        return $this->value;
    }

    /**
     * Get the string from a given graphic.
     */
    public function getString(int $num): string
    {
        return $this->representation[$num];
    }

    /**
     * Get the string for the graphic.
     */
    public function getAsString(): string
    {
        return $this->representation[$this->value];
    }
}

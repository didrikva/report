<?php

namespace App\tests\CardTest;

use App\Card\Card;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardTest extends TestCase
{
    /**
     * Checks right value of card.
     */
    public function testRightValue(): void
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);
        $value = $card->getValue(4);

        $this->assertEquals(6, $value);
    }

    /**
     * Checks if draw is drawing from the right cards.
     */
    public function testDraw(): void
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);
        $value = $card->draw();

        $cards = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
        $this->assertContains($value, $cards);
    }

    /**
     * Checks right string format with [].
     */
    public function testString(): void
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);
        $card->getValue(8);
        $string = $card->getAsString();

        $this->assertEquals('[10]', $string);
    }

    /**
     * Checks if converted to string after draw.
     */
    public function testStrignAfterDraw(): void
    {
        $card = new Card();
        $this->assertInstanceOf("\App\Card\Card", $card);
        $drawn = $card->draw();
        $string = $card->getAsString();

        $this->assertEquals("[$drawn]", $string);
    }
}

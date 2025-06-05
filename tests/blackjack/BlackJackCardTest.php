<?php

namespace App\tests\TestBlackJackCard;

use App\BlackJack\BlackJackCard;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class BlackJackCard
 */
class BlackJackCardTest extends TestCase
{
    /**
     * Checks right value of card.
     */
    public function testRightValue(): void
    {
        $card = new BlackJackCard();
        $this->assertInstanceOf("\App\BlackJack\BlackJackCard", $card);
        $value = $card->getValue(4);

        $this->assertEquals(6, $value);
    }

    /**
     * Checks if draw is drawing from the right cards.
     */
    public function testDraw(): void
    {
        $card = new BlackJackCard();
        $this->assertInstanceOf("\App\BlackJack\BlackJackCard", $card);
        $value = $card->draw();

        $cards = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
        $this->assertContains($value, $cards);
    }

    /**
     * Checks right string format with [].
     */
    public function testString(): void
    {
        $card = new BlackJackCard();
        $this->assertInstanceOf("\App\BlackJack\BlackJackCard", $card);
        $card->getValue(8);
        $string = $card->getAsString();

        $this->assertEquals('10', $string);
    }

    /**
     * Checks if converted to string after draw.
     */
    public function testStringAfterDraw(): void
    {
        $card = new BlackJackCard();
        $this->assertInstanceOf("\App\BlackJack\BlackJackCard", $card);
        $drawn = $card->draw();
        $string = $card->getAsString();

        $this->assertEquals("$drawn", $string);
    }
}

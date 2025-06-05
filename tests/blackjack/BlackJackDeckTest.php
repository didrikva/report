<?php

namespace App\tests\TestBlackJackDeck;

use App\BlackJack\BlackJackDeck;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class BlackJackDeck
 */
class BlackJackDeckTest extends TestCase
{
    /**
     * Checks if deck containes 52 cards.
     */
    public function testDeckHas52(): void
    {
        $deck = new BlackJackDeck();
        $this->assertInstanceOf("\App\BlackJack\BlackJackDeck", $deck);
        $cards = $deck->getValue();
        $this->assertEquals(52, count($cards));
    }

    /**
     * Checks if string function returns array with all values string.
     */
    public function testCheckDeckString(): void
    {
        $deck = new BlackJackDeck();
        $this->assertInstanceOf("\App\BlackJack\BlackJackDeck", $deck);
        $string = $deck->getString();
        $this->assertIsArray($string);
        foreach ($string as $card) {
            $this->assertIsString($card);
        }
    }

    /**
     * Checks if string function returns deck with 52 cards.
     */
    public function testStringHas52(): void
    {
        $deck = new BlackJackDeck();
        $this->assertInstanceOf("\App\BlackJack\BlackJackDeck", $deck);
        $string = $deck->getString();
        $this->assertEquals(52, count($string));
    }

    /**
     * Check if shuffle shuffle cards.
     */
    public function testShuffle(): void
    {
        $deck = new BlackJackDeck();
        $this->assertInstanceOf("\App\BlackJack\BlackJackDeck", $deck);
        $deck->shuffle();
        $new = new BlackJackDeck();
        $this->assertNotEquals($new, $deck);
    }

    /**
     * Check if draw removes right amount of cards from deck.
     */
    public function testDrawAmount(): void
    {
        $deck = new BlackJackDeck();
        $this->assertInstanceOf("\App\BlackJack\BlackJackDeck", $deck);
        $deck->draw(5);
        $cards = $deck->getValue();
        $this->assertEquals(47, count($cards));
    }

    /**
     * Check if draw returns correct amount of drawn.
     */
    public function testDrawDeck(): void
    {
        $deck = new BlackJackDeck();
        $this->assertInstanceOf("\App\BlackJack\BlackJackDeck", $deck);
        $deck->draw(22);
        $cards = $deck->getDrawn();
        $this->assertEquals(22, count($cards));
    }

    /**
     * Check if draw returns correct cards, both drawn and the deck.
     */
    public function testDrawDeckWithOriginal(): void
    {
        $deck = new BlackJackDeck();
        $this->assertInstanceOf("\App\BlackJack\BlackJackDeck", $deck);
        $deck->draw(10);
        $drawn = $deck->getDrawn();
        $value = $deck->getValue();
        $new = new BlackJackDeck();
        $sliced = array_slice($new->getValue(), 0, 10);
        $this->assertEquals($drawn, $sliced);
        $sliced = array_slice($new->getValue(), 10);
        $this->assertEquals($value, $sliced);
    }

}

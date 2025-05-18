<?php

namespace Didrik\tests\DeckOfCardsTest;

use Didrik\Card\DeckOfCards;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class DeckOfCardsTest extends TestCase
{
    /**
     * Checks if deck containes 52 cards.
     */
    public function testDeckHas52()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\Didrik\Card\DeckOfCards", $deck);
        $cards = $deck->getValue();
        $this->assertEquals(52, count($cards));
    }

    /**
     * Checks if string function returns array with all values string.
     */
    public function testCheckDeckString()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\Didrik\Card\DeckOfCards", $deck);
        $string = $deck->getString();
        $this->assertIsArray($string);
        foreach ($string as $card) {
            $this->assertIsString($card);
        }
    }

    /**
     * Checks if string function returns deck with 52 cards.
     */
    public function testStringHas52()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\Didrik\Card\DeckOfCards", $deck);
        $string = $deck->getString();
        $this->assertEquals(52, count($string));
    }

    /**
     * Check if shuffle shuffle cards.
     */
    public function testShuffle()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\Didrik\Card\DeckOfCards", $deck);
        $deck->shuffle();
        $new = new DeckOfCards();
        $this->assertNotEquals($new, $deck);
    }

    /**
     * Check if draw removes right amount of cards from deck.
     */
    public function testDrawAmount()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\Didrik\Card\DeckOfCards", $deck);
        $deck->draw(5);
        $cards = $deck->getValue();
        $this->assertEquals(47, count($cards));
    }

    /**
     * Check if draw returns correct amount of drawn.
     */
    public function testDrawDeck()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\Didrik\Card\DeckOfCards", $deck);
        $deck->draw(22);
        $cards = $deck->getDrawn();
        $this->assertEquals(22, count($cards));
    }

    /**
     * Check if draw returns correct cards, both drawn and the deck.
     */
    public function testDrawDeckWithOriginal()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\Didrik\Card\DeckOfCards", $deck);
        $deck->draw(10);
        $drawn = $deck->getDrawn();
        $value = $deck->getValue();
        $new = new DeckOfCards();
        $sliced = array_slice($new->getValue(), 0, 10);
        $this->assertEquals($drawn, $sliced);
        $sliced = array_slice($new->getValue(), 10);
        $this->assertEquals($value, $sliced);
    }

    /**
     * Check if sorted still has full deck.
     */
    public function testSortAmount()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\Didrik\Card\DeckOfCards", $deck);
        $sorted = $deck->sort();
        $this->assertCount(52, $sorted);
    }

    /**
     * Check if sorted has sorted all numbers and face cards are sorted right.
     */
    public function testSortNUmberAndFace()
    {
        $deck = new DeckOfCards();
        $this->assertInstanceOf("\Didrik\Card\DeckOfCards", $deck);
        $sorted = $deck->sort();
        $number = array_slice($sorted, 0, 40);
        $face = array_slice($sorted, 40);
        $value = ['J', 'Q', 'K', 'A'];
        foreach ($face as $one) {
            $cardValue = substr($one, 1, strpos($one, ']') - 1);
            $this->assertContains($cardValue, $value);
        }
        foreach ($number as $one) {
            $cardValue = substr($one, 1, strpos($one, ']') - 1);
            $this->assertTrue(is_numeric((int) $cardValue));
        }
    }
}

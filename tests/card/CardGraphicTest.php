<?php

namespace Didrik\tests\CardGraphicTest;

use Didrik\Card\CardGraphic;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Checks right value of graphic.
     */
    public function testRightValue(): void
    {
        $graphic = new CardGraphic();
        $this->assertInstanceOf("\Didrik\Card\CardGraphic", $graphic);
        $value = $graphic->getValue(2);

        $this->assertEquals('♣', $value);
    }

    /**
     * Checks string value.
     */
    public function testString(): void
    {
        $graphic = new CardGraphic();
        $this->assertInstanceOf("\Didrik\Card\CardGraphic", $graphic);
        $value = $graphic->getString(2);

        $this->assertEquals('♣', $value);
    }

    /**
     * Checks string after set value.
     */
    public function testStringAfterValue(): void
    {
        $graphic = new CardGraphic();
        $this->assertInstanceOf("\Didrik\Card\CardGraphic", $graphic);
        $value = $graphic->getValue(2);
        $string = $graphic->getString(2);

        $this->assertEquals("$value", $string);
    }

    /**
     * Checks string after set value.
     */
    public function testStringNotInt(): void
    {
        $graphic = new CardGraphic();
        $this->assertInstanceOf("\Didrik\Card\CardGraphic", $graphic);
        $value = $graphic->getValue('0');

        $this->assertEquals('♥', $value);
    }
}

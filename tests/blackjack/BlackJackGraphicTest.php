<?php

namespace App\tests\TestBlackJackGraphic;

use App\BlackJack\BlackJackGraphic;
use PHPUnit\Framework\TestCase;
use Exception;

/**
 * Test cases for class BlackJackGraphic
 */
class BlackJackGraphicTest extends TestCase
{

    /**
     * Checks right value of graphic.
     */
    public function testRightValue(): void
    {
        $graphic = new BlackJackGraphic();
        $this->assertInstanceOf("\App\BlackJack\BlackJackGraphic", $graphic);
        $value = $graphic->getValue(2);

        $this->assertEquals('♣', $value);
    }

    /**
     * Checks string value.
     */
    public function testString(): void
    {
        $graphic = new BlackJackGraphic();
        $this->assertInstanceOf("\App\BlackJack\BlackJackGraphic", $graphic);
        $value = $graphic->getString(1);

        $this->assertEquals('♦', $value);
    }

    /**
     * Checks string after set value.
     */
    public function testStringAfterValue(): void
    {
        $graphic = new BlackJackGraphic();
        $this->assertInstanceOf("\App\BlackJack\BlackJackGraphic", $graphic);
        $value = $graphic->getValue(2);
        $string = $graphic->getString(2);

        $this->assertEquals("$value", $string);
    }

    /**
     * Checks string after set value.
     */
    public function testStringNotInt(): void
    {
        $graphic = new BlackJackGraphic();
        $this->assertInstanceOf("\App\BlackJack\BlackJackGraphic", $graphic);
        $value = $graphic->getValue('0');

        $this->assertEquals('♥', $value);
    }
}

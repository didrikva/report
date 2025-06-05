<?php

namespace App\tests\TestBlackJack;

use App\BlackJack\BlackJack;
use PHPUnit\Framework\TestCase;
use Exception;

/**
 * Test cases for class BlackJack
 */
class BlackJackTest extends TestCase
{
    /**
     * Controlles the right amount of points from the player.
     */
    public function testPlayerpoints(): void
    {
        $game = new BlackJack();
        $this->assertInstanceOf("\App\BlackJack\BlackJack", $game);
        $hand = ['5♥', 'Q♥', '2♥'];
        $points = $game->getPlayerPoints($hand);

        $this->assertEquals(17, $points);
    }

    
    /**
     * Controlles the right amount of points from the player.
     */
    public function testBankpoints(): void
    {
        $game = new BlackJack();
        $this->assertInstanceOf("\App\BlackJack\BlackJack", $game);
        $hand = ['8♥', 'A♥', 'J♥'];
        $points = $game->getBankPoints($hand);

        $this->assertEquals(19, $points);
    }

    /**
     * Check if wrong value is send
     */
    public function testWrongBankpoints(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("To short value");

        $game = new BlackJack();
        $invalidHand = ['K'];
        $game->getBankPoints($invalidHand);
    }

    /**
     * Check if Ess get right value
     */
    public function testEssCalculation(): void
    {
        $game = new BlackJack();
        $this->assertInstanceOf("\App\BlackJack\BlackJack", $game);
        $hand = ['5♥', 'Q♥', 'A♥'];
        $points = $game->getBankPoints($hand);

        $this->assertEquals(16, $points);
    }

    /**
     * Check if Ess change value after to high
     */
    public function testEssCalculationToHigh(): void
    {
        $game = new BlackJack();
        $this->assertInstanceOf("\App\BlackJack\BlackJack", $game);
        $hand = ['A♥', 'A♥', 'A♥'];
        $points = $game->getBankPoints($hand);

        $this->assertEquals(13, $points);
    }
}

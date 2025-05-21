<?php

namespace Didrik\tests\TestGuess21Game;

use Didrik\game_21\Card21Game;
use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Card21Game.
 */
class GuessTest extends TestCase
{
    /**
     * Controlles the right amount of points from the player.
     */
    public function testPlayerpoints(): void
    {
        $game = new Card21Game();
        $this->assertInstanceOf("\Didrik\game_21\Card21Game", $game);
        $hand = ['[5]', '[Q]', '[2]'];
        $points = $game->getPlayerPoints($hand);

        $this->assertEquals(19, $points);
    }

    /**
     * Controlles the right amount of points from the bank.
     */
    public function testBankpoints(): void
    {
        $game = new Card21Game();
        $this->assertInstanceOf("\Didrik\game_21\Card21Game", $game);
        $hand = ['[K]', '[8]'];
        $points = $game->getBankPoints($hand);

        $this->assertEquals(21, $points);
    }

    /**
     * Checks if game is ended, should still be going.
     */
    public function testEndGame(): void
    {
        $game = new Card21Game();
        $this->assertInstanceOf("\Didrik\game_21\Card21Game", $game);
        $endGame = $game->EndGame();

        $this->assertEquals(false, $endGame);
    }

    /**
     * Checks if game is ended, should be gameOver.
     */
    public function testGameOver(): void
    {
        $game = new Card21Game();
        $this->assertInstanceOf("\Didrik\game_21\Card21Game", $game);
        $game->gameOver();
        $endGame = $game->EndGame();

        $this->assertEquals(true, $endGame);
    }

    /**
     * Checks if getDeck and setDeck return correct values.
     */
    public function testSetDeck(): void
    {
        $game = new Card21Game();
        $this->assertInstanceOf("\Didrik\game_21\Card21Game", $game);
        $deck = ['[H2]', '[D3]', '[S5]'];
        $game->setDeck($deck);

        $this->assertEquals($deck, $game->getDeck());
    }

    /**
     * Checks if ess function give ess the right value, expected 1.
     */
    public function testEssCalcOne(): void
    {
        $game = new Card21Game();
        $this->assertInstanceOf("\Didrik\game_21\Card21Game", $game);
        $hand = ['[A]', '[K]', '[4]'];
        $points = $game->getPlayerPoints($hand);

        $this->assertEquals(18, $points);
    }

    /**
     * Checks if ess function give ess the right value, expected 14.
     */
    public function testEssCalc(): void
    {
        $game = new Card21Game();
        $this->assertInstanceOf("\Didrik\game_21\Card21Game", $game);
        $hand = ['[A]', '[2]', '[3]'];
        $points = $game->getPlayerPoints($hand);

        $this->assertEquals(19, $points);
    }
}

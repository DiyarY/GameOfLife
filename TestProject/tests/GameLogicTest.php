<?php
namespace Tests;

use GameOfLife\cellularAutomat\Board;
use GameOfLife\Rules\StandardRule;
use GameOfLife\GameLogic;
use GameOfLife\output\ConsoleOutput;
use Tests\CellularAutomat\BoardFromTextFiller;
use PHPUnit\Framework\TestCase;

/**
 * Tests whether the src\GameLogic works as expected.
 */
class GameLogicTest extends TestCase
{
    /**
     * Tests whether the calculateNextGeneration works as expected.
     *
     * @return void
     */
    public function testDoCalculateNextGenerationWithStandardRule()
    {
        $board = new Board(3,3);
        $standardRule = new StandardRule();
        $gameLogic = new GameLogic($standardRule);

        $boardLayout = <<<BOARD
        ***
        ---
        ---
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);

        $newFieldValue = $standardRule->calculateNewState($board->cell(1,1));
        $this->assertTrue($newFieldValue);

        $gameLogic->calculateNextGeneration($board);
        $consoleOutput->outputBoard($board);

        $boardLayout = <<<BOARD
        ***
        -*-
        **-
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);

        $newFieldValue = $standardRule->calculateNewState($board->cell(1,1));
        $this->assertFalse($newFieldValue);

        $gameLogic->calculateNextGeneration($board);
        $consoleOutput->outputBoard($board);

        $this->assertTrue($board->board[0][0]->isAlive());
        $this->assertFalse($board->board[0][1]->isDead());
        $this->assertTrue($board->board[1][0]->isAlive());
        $this->assertFalse($board->board[1][1]->isDead());
        $this->assertTrue($board->board[2][2]->isAlive());
    }

    /**
     * Tests whether the isLoopDetected function works as expected.
     *
     * @return void
     */
    public function testIsLoopDetected()
    {
        $board = new Board(3,3);
        $standardRule = new StandardRule();
        $gameLogic = new GameLogic($standardRule);

        $boardLayout = <<<BOARD
        ---
        -**
        -**
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);

        $this->assertFalse($gameLogic->isLoopDetected());

        $nextGeneration = $gameLogic->calculateNextGeneration($board);
        $consoleOutput->outputBoard($nextGeneration);

        $nextGeneration = $gameLogic->calculateNextGeneration($board);
        $consoleOutput->outputBoard($nextGeneration);
        $this->assertFalse($gameLogic->isLoopDetected());

        $nextGeneration = $gameLogic->calculateNextGeneration($nextGeneration);
        $consoleOutput->outputBoard($nextGeneration);
        $this->assertFalse($gameLogic->isLoopDetected());

        $nextGeneration = $gameLogic->calculateNextGeneration($nextGeneration);
        $consoleOutput->outputBoard($nextGeneration);
        $this->assertFalse($gameLogic->isLoopDetected());

        $nextGeneration = $gameLogic->calculateNextGeneration($nextGeneration);
        $consoleOutput->outputBoard($nextGeneration);
        $this->assertFalse($gameLogic->isLoopDetected());

        $nextGeneration = $gameLogic->calculateNextGeneration($nextGeneration);
        $consoleOutput->outputBoard($nextGeneration);
        $this->assertTrue($gameLogic->isLoopDetected());
    }

    /**
     * Tests whether the board-template is detected in the original board-index.
     *
     * @return void
     */
    public function testCompareGenerationsWithSetBoardTemplate()
    {
        $board = new Board(3,3);
        $temp = new Board(3,3);
        $rule = new StandardRule();
        $gameLogic = new GameLogic($rule);

        $tempLayout = <<<BOARD
        *-*
        ---
        *-*
BOARD;

        $boardFiller2 = new BoardFromTextFiller();
        $boardFiller2->fillBoardFromText($temp, $tempLayout);
        $consoleOutput2 = new ConsoleOutput();
        $consoleOutput2->outputBoard($temp);

        $boardLayout = <<<BOARD
        ---
        -**
        -**
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);

        for ($i = 0; $i < 5; $i++)
        {
            $nextGeneration = $gameLogic->calculateNextGeneration($board);
            $nextGeneration = $gameLogic->calculateNextGeneration($nextGeneration);

            if ($nextGeneration === $temp)
            {
                $this->assertTrue($gameLogic->isLoopDetected());
                break;
            }
            else $this->assertFalse($gameLogic->isLoopDetected());
        }
    }
}
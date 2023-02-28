<?php
namespace Tests\Rules;

use GameOfLife\cellularAutomat\Board;
use GameOfLife\output\ConsoleOutput;
use GameOfLife\Rules\CopyRule;
use Tests\CellularAutomat\BoardFromTextFiller;
use PHPUnit\Framework\TestCase;

/**
 * Tests whether the /CopyRule works as expected.
 */
class CopyRuleTest extends TestCase
{
    /**
     * Tests whether the calculateNewState function works as expected or not.
     *
     * @return void Returns the entire board with the set dead/living fields.
     */
    public function testCalculateNewState()
    {
        $board = new Board(10, 10);
        $rule = new CopyRule();
        $boardLayout = <<<BOARD
        ----------
        ----**----
        -----*----
        ---*------
        ----------
        ----------
        ----------
        ----------
        ----------
        ----------
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        /*
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);
        */

        $newFieldValue = $rule->calculateNewState($board->cell(2,4));
        $this->assertFalse($newFieldValue);
    }

    /**
     * Tests whether a dead field with 8 living neighbors stays dead in the next
     * generation or not.
     *
     * @return void Returns the entire board with the set dead/living fields.
     */
    public function testDeadFieldStaysDeadWith8LivingNeighbors()
    {
        $board = new Board(5,5);
        $rule = new CopyRule();
        $boardLayout = <<<BOARD
        -***-
        -*-*-
        -***-
        -----
        -----
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        /*
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);
        */

        $newFieldValue = $rule->calculateNewState($board->cell(1,2));
        $this->assertFalse($newFieldValue);
    }

    /**
     * Tests whether a living field with 1 living neighbor survives in the next
     * generation or not.
     *
     * @return void Returns the entire board with the set dead/living fields.
     */
    public function testLivingFieldSurvivesWith1LivingNeighbor()
    {
        $board = new Board(5,5);
        $rule = new CopyRule();
        $boardLayout = <<<BOARD
        *----
        -*---
        -----
        -----
        -----
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        /*
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);
        */

        $newFieldValue = $rule->calculateNewState($board->cell(1,1));
        $this->assertTrue($newFieldValue);
    }

    /**
     * Tests whether a living cell with 7 living neighbors survives in the next
     * generation or not.
     *
     * @return void Returns the entire board with the set dead/living fields.
     */
    public function testLivingFieldSurvivesWith7LivingNeighbors()
    {
        $board = new Board(5,5);
        $rule = new CopyRule();
        $boardLayout = <<<BOARD
        -***-
        -***-
        -**--
        -----
        -----
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        /*
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);
        */

        $newFieldValue = $rule->calculateNewState($board->cell(1,2));
        $this->assertTrue($newFieldValue);
    }
}
<?php
namespace Tests\Rules;

use GameOfLife\cellularAutomat\Board;
use GameOfLife\GameLogic;
use GameOfLife\output\ConsoleOutput;
use GameOfLife\Rules\StandardRule;
use PHPUnit\Framework\TestCase;
use Tests\CellularAutomat\BoardFromTextFiller;

/**
 * Tests whether \Rules\StandardRule works as expected.
 */
class StandardRuleTest extends TestCase
{
    /**
     * Tests the state of the cell.
     *
     * @return void
     */
    public function testCalculateNewState()
    {
        $board = new Board(4,4);
        $rule = new StandardRule();

        $fieldValue = $rule->calculateNewState($board->cell(1,1));
        $this->assertFalse($fieldValue);

        $board->setCell(2,2, true);
        $fieldValue2 = $rule->calculateNewState($board->cell(2,2));
        $this->assertFalse($fieldValue2);
    }

    /**
     * Tests whether a field survives in the next generation which is surrounded by at least 2 living neighbors.
     *
     * @return void
     */
    public function testSurvivesWith2LivingNeighbors()
    {
        $board = new Board(4,4);
        $rule = new StandardRule();
        $boardLayout = <<<BOARD
        *---
        **--
        ----
        ----
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board,$boardLayout);
        /*
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);
        */

        $newFieldValue = $rule->calculateNewState($board->cell(1,1));
        $this->assertTrue($newFieldValue);
    }

    /**
     * Tests whether a dead field lives in the next generation which is surrounded by exactly 3 neighbors.
     *
     * @return void
     */
    public function testFieldLivesInNextGenerationBy3LivingNeighbors()
    {
        $board = new Board(4,4);
        $rule = new StandardRule();

        $boardLayout = <<<BOARD
        ----
        ***-
        ----
        ----
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        /*
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);
        */

        $newFieldValue = $rule->calculateNewState($board->cell(0,1));
        $this->assertTrue($newFieldValue);
    }

    /**
     * Tests whether a living field lives in the next generation which is surrounded
     * by either 2 or 3 living neighbors.
     *
     * @return void
     */
    public function testLivingCellBy2Or3LivingNeighbors()
    {
        $board = new Board(4,4);
        $rule = new StandardRule();

        $boardLayout = <<<BOARD
        -*--
        **--
        --*-
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
     * Tests whether a living field dies in the next generation by overpopulation surrounded by more than 3 living
     * neighbors.
     *
     * @return void
     */
    public function testLivingCellDiesByOverpopulationOfMoreThen3LivingNeighbors()
    {
        $board =new Board(4,4);
        $rule = new StandardRule();

        $boardLayout = <<<BOARD
        ***-
        -**-
        *---
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        /*
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);
        */

        $newFieldValue = $rule->calculateNewState($board->cell(1,1));
        $this->assertFalse($newFieldValue);
    }
}
<?php
namespace Tests\Rules;

use GameOfLife\output\ConsoleOutput;
use GameOfLife\Rules\Two45Rule;
use PHPUnit\Framework\TestCase;
use GameOfLife\cellularAutomat\Board;
use Tests\CellularAutomat\BoardFromTextFiller;

/**
 * Tests whether the /Two45Rule works as expected.
 */
class Two45RuleTest extends TestCase
{
    /**
     * Tests whether the calculateNewState function works as expected or not.
     *
     * @return void Returns the entire board with the set dead/living fields.
     */
    public function testCalculateNewState()
    {
        $board = new Board(5,5);
        $rule = new Two45Rule();
        $boardLayout = <<<BOARD
        -----
        -----
        -----
        -----
        -----
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);

        $newFieldValue = $rule->calculateNewState($board->cell(1,1));
        $this->assertFalse($newFieldValue);
    }

    /**
     * Tests whether a living field with 4 living Neighbors survives
     * in the next generation or not.
     *
     * @return void Returns the entire board with the set dead/living fields.
     */
    public function testLivingFieldSurvivesWith4LivingNeighbors()
    {
        $board = new Board(5,5);
        $rule = new Two45Rule();
        $boardLayout = <<<BOARD
        ***--
        -**--
        -----
        -----
        -----
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);

        $newFieldValue = $rule->calculateNewState($board->cell(1,1));
        $this->assertTrue($newFieldValue);
    }

    /**
     * Tests whether a dead field with 5 living neighbors will be reborn in the next
     * generation or not.
     *
     * @return void Returns the entire board with the set dead/living fields.
     */
    public function testDeadFieldWith5LivingNeighborsWillBeRebornInTheNextGeneration()
    {
        $board = new Board(5,5);
        $rule = new Two45Rule();
        $boardLayout = <<<BOARD
        ***--
        --*--
        --*--
        -----
        -----
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);

        $newFieldValue = $rule->calculateNewState($board->cell(1,1));
        $this->assertTrue($newFieldValue);
    }

    /**
     * Tests whether a dead field stays dead in the next generation with 3 living
     * neighbors or not.
     *
     * @return void Returns the entire board with the set dead/living fields.
     */
    public function testDeadFieldStaysDeadWith3LivingNeighbors()
    {
        $board = new Board(5,5);
        $rule = new Two45Rule();
        $boardLayout = <<<BOARD
        ***--
        -----
        -----
        -----
        -----
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);

        $newFieldValue = $rule->calculateNewState($board->cell(1,1));
        $this->assertFalse($newFieldValue);
    }

    /**
     * Tests whether a living field dies with 8 living neighbors in the next generation
     * or not.
     *
     * @return void Returns the entire board with the set dead/living fields.
     */
    public function testLivingFieldDiesWith8LivingNeighbors()
    {
        $board = new Board(5,5);
        $rule = new Two45Rule();
        $boardLayout = <<<BOARD
        ***--
        ***--
        ***--
        -----
        -----
BOARD;

        $boardFiller = new BoardFromTextFiller();
        $boardFiller->fillBoardFromText($board, $boardLayout);
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->outputBoard($board);

        $newFieldValue = $rule->calculateNewState($board->cell(1,1));
        $this->assertFalse($newFieldValue);
    }
}
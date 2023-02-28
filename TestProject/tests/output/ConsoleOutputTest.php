<?php
namespace Tests\Output;

use GameOfLife\CellularAutomat\Board;
use GameOfLife\Output\ConsoleOutput;
use PHPUnit\Framework\TestCase;

/**
 * Tests whether \Output\ConsoleOutput works as expected.
 */
class ConsoleOutputTest extends TestCase
{
    protected $boardOutput;
    protected $board;

    /**
     * Initialisation of the current board.
     * Initialisation of the ConsoleOutput-cass.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->boardOutput = new ConsoleOutput();
        $this->board = new Board(5,5);
    }

    /**
     * Asserts that two strings, which are representing the current board, are equal.
     *
     * @test
     */
    public function outputOfAnEmptyBoard()
    {
        $this->expectOutputString("-----\n-----\n-----\n-----\n-----\n\n");
        $this->boardOutput->outputBoard($this->board);
    }

    /**
     * Asserts that two strings, with the cell that is set on true in both strings, are equal.
     *
     * @test
     */
    public function setFieldOnTheCurrentBoard()
    {
        $this->expectOutputString("-----\n-*---\n-----\n-----\n-----\n\n");
        $this->board->setCell(1,1,1);
        $this->boardOutput->outputBoard($this->board);
    }
}
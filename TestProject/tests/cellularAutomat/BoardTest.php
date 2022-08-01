<?php

namespace Tests\CellularAutomat;

use GameOfLife\cellularAutomat\Board;
use PHPUnit\Framework\TestCase;

/**
 * Tests whether \CellularAutomat\Board works as expected.
 */
class BoardTest extends TestCase
{
    protected $board;

    protected $width = 10;
    protected $height = 10;
    protected $x = 5;
    protected $y = 5;

    /**
     * Sets height and width of the board.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->board = new Board(10, 10);
    }

    /**
     * Initialize an empty board -> cells are all set on 0.
     *
     * @param $_board
     * @return bool
     */
    private function emptyBoard($_board)
    {
        $boardIsEmpty = true;
        foreach ($_board as $row)
        {
            foreach ($row as $cell)
            {
                if ($cell != 0)
                    $boardIsEmpty = false;
            }
        }
        return $boardIsEmpty;
    }

    /**
     * Asserts that width has the same value that was defined inside the constructor.
     *
     * @return void
     * @test
     */
    public function checksConstructorWidthIsActuallyWidth()
    {
        $this->assertEquals(10, $this->board->getWidth());
    }

    /**
     * Asserts that height has the same value that was defined inside the constructor.
     *
     * @return void
     * @test
     */
    public function checksIfConstructorHeightIsActuallyHeight()
    {
        $this->assertEquals(10, $this->board->getHeight());
    }

    /**
     * Asserts that the created board  is empty.
     *
     * @test
     */
    public function boardIsEmpty()
    {
        $board = $this->board->getBoard();
        $boardIsEmpty = $this->emptyBoard($board);

        $this->assertTrue($boardIsEmpty);
    }

    /**
     * Asserts that the created board is not empty.
     *
     * @test
     */
    public function setCellAssertBoardIsNotEmpty()
    {
        $this->board->setCell(0,0,1);
        $board = $this->board->getBoard();

        $boardIsEmpty = $this->emptyBoard($board);

        $this->assertNotTrue($boardIsEmpty);
    }

    /**
     * Asserts that a cell on the defined coordinate is true -> living cell.
     *
     * @test
     */
    public function livingNeighbors()
    {
        $board = new Board($this->width, $this->height);

        $this->assertEquals(0, $board->countLivingNeighbors($this->x, $this->y));
        $board->setCell(1,1,1);
        $board->setCell(2,1,1);
        $board->setCell(3,1,1);
        $this->assertEquals(1, $board->countLivingNeighbors(1,1));
    }

    /**
     * Asserts that the old generation is equal to the current generation.
     *
     * @test
     * @return void
     */
    public function NextGeneration()
    {
        $board = new Board($this->width, $this->height);
        $board->setCell(1,1,1);
        $board->setCell(2,1,1);
        $board->setCell(3,1,1);
        $oldBoard = $board->getBoard();
        $board->calculateNextGeneration();
        $this->assertNotEquals($oldBoard, $board->getBoard());
        $this->assertEquals($this->width * $this->height, count($board->getBoard(), COUNT_RECURSIVE) - $this->width);
    }

}
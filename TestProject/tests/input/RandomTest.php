<?php

namespace Tests\Input;

use GameOfLife\Options\Getopt;
use GameOfLife\CellularAutomat\Board;
use GameOfLife\Input\Random;
use PHPUnit\Framework\TestCase;

/**
 * Tests whether \Input\Random works as expected.
 */
class RandomTest extends TestCase
{
    protected $randomInput;
    protected $getOption;

    /**
     * Initialization of the Random class.
     *
     * \options\Getopt will be mocked.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->randomInput = new Random();
        $this->getOption = $this->createMock(Getopt::class);
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
     * Asserts that the board, with the random initialised living-cells, is not empty.
     *
     * @test
     */
    public function prepareRandomInput()
    {
        $board = new Board(10, 10);

        $this->randomInput->fillBoard($board, $this->getOption);

        $this->assertNotEmpty($this->emptyBoard($board->getBoard()));
    }

    /**
     * Asserts that the board, with a defined filling-level that sets the random-chosen cells on true, is not empty.
     *
     * @test
     */
    public function fillBoardAndSetFillGrade()
    {
        $board = new Board(10, 10);
        $this->getOption->method("addOptions")
            ->with("fillingLevel")
            ->willReturn("50");

        $this->randomInput->fillBoard($board, $this->getOption);

        $this->assertNotEmpty($this->emptyBoard($board->getBoard()));
    }
}
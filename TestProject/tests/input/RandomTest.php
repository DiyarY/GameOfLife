<?php
namespace Tests\Input;

use GameOfLife\cellularAutomat\Field;
use GameOfLife\Options\Getopt;
use GameOfLife\CellularAutomat\Board;
use GameOfLife\Input\Random;
use PHPUnit\Framework\TestCase;

/**
 * Tests whether \Input\Random works as expected.
 */
class RandomTest extends TestCase
{
    /**
     * @var Random $randomInput Random-class.
     * @var Getopt|(Getopt&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
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
     * Checks whether the board - a two-dimensional array - is empty.
     *
     * @param Field[][] $_board Board.
     * @return bool Is empty or not.
     */
    private function checkBoardArrayEmpty(array $_board): bool
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
     */
    public function testPrepareRandomInput()
    {
        $board = new Board(10, 10);

        $this->randomInput->fillBoard($board, $this->getOption);

        $this->assertNotEmpty($this->checkBoardArrayEmpty($board->getFieldBoard()));
    }

    /**
     * Asserts that the board, with a defined filling-level that sets the random-chosen cells on true, is not empty.
     */
    public function testFillBoardAndSetFillGrade()
    {
        $board = new Board(10, 10);
        $this->getOption->method("addOptions")
            ->with("fillingLevel")
            ->willReturn("50");

        $this->randomInput->fillBoard($board, $this->getOption);

        //Iterates through the board and checks whether the value of the fillingLevel matches as expected.
        foreach ($board as $row)
        {
            foreach ($row as $cell)
            {
                if ($cell != 0)
                {
                    $livingCells = count($cell);
                    if ($livingCells == 50 || $livingCells == 49 || $livingCells == 48)
                    {
                        $this->assertNotEmpty($this->checkBoardArrayEmpty($board->getFieldBoard()));
                    }
                }
            }
        }
    }
}
<?php
namespace Tests\CellularAutomat;

use GameOfLife\cellularAutomat\Board;
use GameOfLife\cellularAutomat\Field;
use PHPUnit\Framework\TestCase;

/**
 * Tests whether \CellularAutomat\Board works as expected.
 */
class BoardTest extends TestCase
{
    /**
     * @var Board $board Defines the current board.
     */
    protected $board;
    /**
     * @var int $x Defines the width of the board.
     */
    protected $x = 5;
    /**
     * @var int $y Defines the height of the board.
     */
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
     * Checks whether the board - a two-dimensional array - is empty.
     *
     * @param Field[][] $_board
     * @return bool Is Empty or not.
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
     * Asserts that width has the same value that was defined inside the constructor.
     *
     * @return void
     */
    public function testChecksConstructorWidthIsActuallyWidth()
    {
        $this->assertEquals(10, $this->board->width());
    }

    /**
     * Asserts that height has the same value that was defined inside the constructor.
     *
     * @return void
     */
    public function testChecksIfConstructorHeightIsActuallyHeight()
    {
        $this->assertEquals(10, $this->board->height());
    }

    /**
     * Asserts that the created board  is empty.
     */
    public function testBoardIsEmpty()
    {
        $board = $this->board->getFieldBoard();

        $this->assertTrue($this->checkBoardArrayEmpty($board));
    }

    /**
     * Asserts that the created board is not empty.
     */
    public function testCreatesNonEmptyBoardBySettingACellOnTrue()
    {
        $this->board->setCell(0,0,1);
        $board = $this->board->getFieldBoard();

        $this->assertNotTrue($this->checkBoardArrayEmpty($board));
    }

    /**
     * Tests whether the neighbors in the upper left corner are detected or not.
     *
     * @return void
     */
    public function testGetNeighborsUpperLeft()
    {
        $expectedNeighborCoordinates=[];
        $expectedNeighborCoordinates[]= array(0,1);
        $expectedNeighborCoordinates[]= array(1,1);
        $expectedNeighborCoordinates[]= array(1,0);

        $neighbors = $this->board->getNeighboursOfField($this->board->cell(0,0));

        foreach ($expectedNeighborCoordinates as $expectedNeighborCoordinate)
        {
            $neighborFound=false;
            foreach ($neighbors as $neighbor)
            {
                if ($neighbor->x()==$expectedNeighborCoordinate[0] && $neighbor->y()==$expectedNeighborCoordinate[1])
                {
                    $neighborFound = true;
                }
            }
            $this->assertEquals(true,$neighborFound,"Did not find expected neighbor at $expectedNeighborCoordinate[0],$expectedNeighborCoordinate[1]");
        }
    }

    /**
     * Tests whether the coordinates in the bottom right corner are detected or not.
     *
     * @return void
     */
    public function testGetNeighborsBottomRight()
    {
        $expectedNeighborCoordinates = [];
        $expectedNeighborCoordinates[] = array(8,9);
        $expectedNeighborCoordinates[] = array(9,9);
        $expectedNeighborCoordinates[] = array(9,8);

        $neighborsBottomRight = $this->board->getNeighboursOfField($this->board->cell(8,8));

        foreach ($expectedNeighborCoordinates as $expectedNeighborCoordinate)
        {
            $neighborFound=false;
            foreach ($neighborsBottomRight as $neighborBottomRight)
            {
                if ($neighborBottomRight->x()==$expectedNeighborCoordinate[0] && $neighborBottomRight->y()==$expectedNeighborCoordinate[1])
                {
                    $neighborFound = true;
                }
            }
            $this->assertEquals(true,$neighborFound,"Did not find expected neighbor at $expectedNeighborCoordinate[0],$expectedNeighborCoordinate[1]");
        }
    }

    /**
     * checks whether the coordinate of the filed in the middle of the board is detected or not.
     *
     * @return void
     */
    public function testGetMiddleFieldOfBoard()
    {
        $expectedCoordinate[] = array(4,4);

        $centerFieldOfBoard = $this->board->getNeighboursOfField($this->board->cell(3,3));

        foreach ($expectedCoordinate as $centerCoordinate)
        {
            $center = false;
            foreach ($centerFieldOfBoard as $centerField)
            {
                if ($centerField->x() == $centerCoordinate[0] && $centerField->y() == $centerCoordinate[1])
                {
                    $center = true;
                }
            }
            $this->assertEquals(true,$center, "Did not find center field $centerCoordinate[0], $centerCoordinate[1]");
        }
    }
}
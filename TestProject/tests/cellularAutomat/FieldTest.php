<?php
namespace Tests\Rules;

use GameOfLife\cellularAutomat\Board;
use GameOfLife\cellularAutomat\Field;
use PHPUnit\Framework\TestCase;
/**
 * Tests whether cellularAutomat/Field works as expected.
 */
class FieldTest extends TestCase
{
    /**
     * Constructed coordinates for the x- and y- coordinates.
     */
    public function testConstructedCoordinatesAreReturned()
    {
        $board = new Board(5,5);
        $cell = new Field($board, 1,2);
        $this->assertEquals(1, $cell->x());
        $this->assertEquals(2, $cell->y());
    }

    /**
     * Asserts that value of the cel is equals.
     */
    public function testSetValuesOnEqual()
    {
        $board = new Board(5,5);
        $cell = new Field($board, 0,0);

        $cell->setValue(50);
        $this->assertEquals(50, $cell->getValue());
    }

    /**
     * Asserts that the cell is dead.
     */
    public function testIsDead()
    {
        $board = new Board(5,5);
        $cell = new Field($board, 0,0);
        $cell->setValue(false);

        $this->assertFalse($cell->isDead());
    }

    /**
     * Asserts that the cell is alive.
     */
    public function testIsAlive()
    {
        $board = new Board(5,5);
        $cell = new Field($board, 0,0);

        $cell->setValue(1);
        $this->assertTrue($cell->isAlive());
    }

    /**
     * Asserts that the number of the living neighbors are set on true.
     */
    public function testNumberOfLivingNeighbours()
    {
        $board = new Board(10, 10);
        $board->board[1][1]->setValue(1);
        $board->board[2][1]->setValue(1);
        $board->board[1][2]->setValue(1);
        $board->board[2][2]->setValue(1);
        $this->assertEquals(3, $board->board[2][2]->numberOfLivingNeighbors());
        $this->assertEquals(2, $board->board[3][2]->numberOfLivingNeighbors());
        $this->assertEquals(0, $board->board[5][5]->numberOfLivingNeighbors());
    }

    /**
     * Asserts that the number of dead neighbours are set on false.
     */
    public function testNumberOfDeadNeighbours()
    {
        $board = new Board(10, 10);
        $board->board[1][1]->setValue(1);
        $board->board[2][1]->setValue(1);
        $board->board[1][2]->setValue(1);
        $board->board[2][2]->setValue(1);
        $this->assertEquals(5, $board->board[2][2]->numberOfDeadNeighbors());
    }
}
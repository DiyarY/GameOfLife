<?php
namespace GameOfLife\cellularAutomat;

/**
 * Class Field represents a single cell of the board.
 */
class Field
{
    /**
     * @var bool $isAlive Defines whether the field/cell is false/true.
     */
    private $isAlive;
    /**
     * @var Board $board Defines the current board.
     */
    private $board;
    /**
     * @var int $x Defines the x-coordinate of the board.
     */
    private $x;
    /**
     * @var int $y Defines the y-coordinate of the board.
     */
    private $y;

    /**
     * @param Board $_board represents the parent board.
     * @param int $_x X-coordinate.
     * @param int $_y Y-coordinate.
     */
    public function __construct(Board $_board, $_x, $_y)
    {
        if ($_x < 0) throw new \RuntimeException("X value '$_x' is smaller than the allowed 0");
        if ($_y < 0) throw new \RuntimeException("Y value '$_y' is smaller than the allowed 0");
        if ($_x > $_board->width()) throw new \RuntimeException("X value '$_x' is bigger than the allowed board with of " . $_board->width());
        if ($_y > $_board->height()) throw new \RuntimeException("Y value '$_y' is bigger than the allowed border height of " . $_board->height());

        $this->x = $_x;
        $this->y = $_y;
        $this->board = $_board;

        $this->isAlive = false;
    }

    /**
     * Sets the value of the cell.
     *
     * @param bool $_value represents the new cell value.
     */
    public function setValue(bool $_value)
    {
        $this->isAlive = $_value;
    }

    /**
     * Returns the new value of the customised cell.
     *
     * @return bool new value of the cell.
     */
    public function value()
    {
        return $this->isAlive;
    }

    /**
     * Returns the cell which is true/lives.
     *
     * @return bool returns true if the cell is alive otherwise it'll be false.
     */
    public function isAlive()
    {
        return true;
    }

    /**
     * Returns the cell which is false/dead.
     *
     * @return bool returns true if the cell is alive otherwise it'll be false.
     */
    public function isDead()
    {
        return false;
    }

    /**
     * Returns the x-coordinate of the cell.
     *
     * @return int X-coordinate.
     */
    public function x()
    {
        return $this->x;
    }

    /**
     * Returns the y-coordinate of the cell.
     *
     * @return int Y-coordinate.
     */
    public function y()
    {
        return $this->y;
    }

    /**
     * Returns the number of living neighbours.
     *
     * @return int number of living neighbours.
     */
    public function numberOfLivingNeighbors(): int
    {
        $neighbors = $this->board->getNeighboursOfField($this);
        $numberOfLivingNeighbors = 0;
        foreach ($neighbors as $neighborField) {
            if ($neighborField->value() == 1) $numberOfLivingNeighbors++;
        }
        return $numberOfLivingNeighbors;
    }

    /**
     * Returns the number of dead neighbors.
     *
     * @return int number of dead neighbors.
     */
    public function numberOfDeadNeighbors(): int
    {
        $neighbors = $this->board->getNeighboursOfField($this);
        $numberOfDeadNeighbors = 0;
        foreach ($neighbors as $neighborField) {
            if ($neighborField->value() == 0) $numberOfDeadNeighbors++;
        }
        return $numberOfDeadNeighbors;
    }
}

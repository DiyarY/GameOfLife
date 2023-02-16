<?php
namespace GameOfLife\cellularAutomat;

/**
 * This is a small basic project about conways game of Life
 *
 * Conways Game of Life is a two-dimensional grid of squares and cells or numbers (alive: 1, dead: 0),
 * where each cell has two possible states, alive or dead. Each cell interacts with its eight neighbours,
 * which are the cells that are horizontally, vertically or diagonally adjacent.
 *
 *   1. Any live cell with fewer than two live neighbours dies, as if caused by under-population.
 *   2. Any live cell with two or three live neighbours lives on to the next generation.
 *   3. Any live cell with more than three live neighbours dies, as if by overcrowding.
 *   4. Any dead cell with exactly three live neighbours becomes a live cell, as if by reproduction.
 */
class Board
{
    /**
     * @var $height
     * @var $width
     * @var $board = [[]]
     * @var array[]|Field[][]
     */
    private $height;
    private $width;
    public $board = [[]];

    /**
     * Creates an empty Board with set Height and Width.
     *
     * @param int $_height Height of the Board
     * @param int $_width Width of the Board.
     */
    function __construct($_height, $_width)
    {
        $this->height=$_height;
        $this->width=$_width;
        $this->board = $this->emptyField();
    }

    /**
     * Returns an empty Board.
     *
     * @return Field[][] Represents a field.
     */
    public function emptyField(): array
    {
        $newBoard = [[]];
        for ($y = 0; $y < $this->height; $y++)
        {
            for ($x = 0; $x < $this->width; $x++)
            {
                $newBoard[$y][$x] = new Field($this, $x, $y);
            }
        }
        return $newBoard;
    }

    /**
     * Returns height of board.
     *
     * @return array[]|Field[][]|int
     */
    function getHeight()
    {
        return $this->height;
    }

    /**
     * Returns width of the board.
     *
     * @return int
     */
    function getWidth(): int
    {
        return $this->width;
    }

    /**
     * Changes the value of a cell.
     *
     * @param int $_x X-coordinate
     * @param int $_y Y-coordinate
     * @param bool $_value State of the cell.
     * @return mixed
     */
    function setCell($_x, $_y, bool $_value)
    {
        if ($_x < 0 || $_y < 0 || $_x >= $this->getWidth() || $_y >= $this->getHeight())
            return null;

        $this->board[$_x][$_y]->setValue($_value);

        return $_value;
    }

    /**
     * Returns the number of the living neighbours around the set cell.
     *
     * @param Field $_field The field to get the neighbors from
     * @return Field[] All the neighbors of the given \c $_field
     */
    function getNeighborsOfField(Field $_field)
    {
        $neighborFields = [];
        $x = $_field->x();
        $y = $_field->y();

        //Analyzing the neighbours around the respective fields
        $coordinates = [
            [-1, -1], [-1, 0], [-1, 1],
            [0, -1], [0, 1],
            [1, -1], [1, 0], [1, 1]
        ];

        foreach ($coordinates as $coordinate) {
            if (isset($this->board[$x + $coordinate[0]][$y + $coordinate[1]]))
                $neighborFields[] = $this->board[$x + $coordinate[0] ][$y + $coordinate[1] ];
        }
        return $neighborFields;
    }

    /**
     * Returns the cell at the given coordinates.
     *
     * @param int $_x X-coordinate of the cell.
     * @param int $_y Y-coordinate of the cell.
     * @return Field|null State of the cell or null for invalid coordinates.
     */
    function cell(int $_x, int $_y): ?Field
    {
        //Checks whether coordinate is out of border
        if ($_x < 0 || $_y < 0 || $_x >= $this->getWidth() || $_y >= $this->getHeight())
            return null;

        return $this->board[$_x][$_y];
    }

    /**
     * Returns a copy of the board.
     *
     * @return array Returns board.
     */
    public function getFieldBoard(): array
    {
        $newBoard = array();

        for ($y = 0; $y < $this->height; $y++)
        {
            for ($x = 0; $x < $this->width; $x++)
            {
                $newBoard[$x][$y] = $this->board[$x][$y]->getValue();
            }
        }
        return $newBoard;
    }
}
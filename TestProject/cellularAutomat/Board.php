<?php
namespace cellularAutomat;

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
     * @var $lastGeneration = []
     */
    private $height;
    private $width;
    private $board = [[]];
    private $lastGeneration = [];

    /**
     * Set the total numbers of the rows and cols.
     *
     * @param $_height
     * @param $_width
     */
    function __construct($_height, $_width)
    {
        $this->height=$_height;
        $this->width=$_width;

        //Creates a new Board by the set number of the attributes $height and $width, which marks the x/y-axis
        for ($y = 0; $y < $this->height; ++$y) {
            $row = [];
            for ($x = 0; $x < $this->width; ++$x) {
                $this->board[$y][$x] = 0;
                $row[$x] = 0;
            }
            $this->board[$y] = $row;
        }
    }

    /**
     * Create the board
     */
    function createBoard(){
        for ($y = 0; $y < $this->height; ++$y) {
            $row = [];
            for ($x = 0; $x < $this->width; ++$x) {
                $row[$x] = rand(0,1);
            }
            $this->board[$y] = $row;
        }
    }

    /**
     * The living and dead neighbors will be counted around the base cell.
     *
     * @param $x
     * @param $y
     * @return int
     */
    function countLivingNeighbors($x, $y): int
    {
        //Analyzing the living/dead neighbours
        $coordinates = [
            [-1, -1], [-1, 0], [-1, 1],
            [0, -1], [0, 1],
            [1, -1], [1, 0], [1, 1]
        ];
        $count = 0;


        foreach ($coordinates as $coordinate)
        {
            if (isset($this->board[$x + $coordinate[0]][$y + $coordinate[1]])
                && $this->board[$x + $coordinate[0]][$y + $coordinate[1]] == 1)
            {
                $count++;
            }
        }
        return $count;
    }

    /**
     * On base of the living and dead neighbors the next generation will be calculated.
     */
    function calculateNextGeneration()
    {
        $newBoard = [];

        foreach ($this->board as $widthID => $width)
        {
            $newBoard[$widthID] = [];
            foreach ($width as $heightID => $height)
            {
                $count = $this->countLivingNeighbors($widthID, $heightID);

                $newValue=null;
                if ($height == 1)
                {
                    if ($count < 2 || $count > 3)
                    {
                        $newValue=0;
                    } else
                    {
                        $newValue=1;
                    }
                } else
                {
                    if ($count == 3)
                    {
                        $newValue = 1;
                    }
                }

                $newBoard[$widthID][$heightID] = $newValue;
            }
        }
        $this->lastGeneration[] = $this->board;
        $this->board = $newBoard;
    }

    /**
     * A glider function which runs/glides through the whole board.
     */
    function createGlider()
    {
        for ($y = 0; $y < $this->height; ++$y) {
            $row = [];
            for ($x = 0; $x < $this->width; ++$x) {
                $row[$x] = 0;
            }
            $this->board[$y] = $row;
        }
        $this->board[1][0]=1;
        $this->board[2][1]=1;
        $this->board[2][2]=1;
        $this->board[1][2]=1;
        $this->board[0][2]=1;
    }

    /**
     * Print out the board: living cells are marked as 1, dead cells are marked as 0.
     */
    function printOutBoard()
    {
        for ($y = 0; $y < $this->height; ++$y)
        {
            for ($x = 0; $x < $this->width; ++$x)
            {
                //the dead cells
                $liveOrdead= " - ";
                if ($this->board[$y][$x] == 1)

                    //living cells
                    $liveOrdead=" * ";
                echo $liveOrdead;

            }
            echo "\n";
        }
    }

    /**
     * Check the current board if it has similarity with the previous board.
     *
     * @return bool
     */
    function checkBoardOnSimilarities(): bool
    {
            $lastBoard = $this->lastGeneration[count($this->lastGeneration) -1];
            $actualBoard = $this->board;

            if ($lastBoard == $actualBoard) return true;

            return false;
    }

    /**
     * @param $_height
     */
    function setHeight($_height)
    {
        $this->height=$_height;
    }

    /**
     * @return int
     */
    function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @param $_width
     */
    function setWidth($_width)
    {
        $this->width=$_width;
    }

    /**
     * @return int
     */
    function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return array[]
     */
    function getBoard(): array
    {
        return $this->board;
    }

    /**
     * @param $_x
     * @param $_y
     * @param $_value
     * @return mixed
     */
    function setCell($_x, $_y, $_value)
    {
        return $this->board[$_x][$_y]= $_value;
    }

}
<?php

class CellularAutomat
{
    /**
     * Dekleration of the rows, cols and the board.
     *
     * @var $heigth
     * @var $width
     * @var $board
     */
    public $heigth;
    public $width;
    public $board = [[]];

    /**
     * Set the total numbers of the rows and cols.
     *
     * @param $_heigth
     * @param $_width
     */
    function __construct($_heigth, $_width)
    {
        $this->heigth=$_heigth;
        $this->width=$_width;
    }

    /**
     * Create the board
     */
    function createBoard(){
        for($y = 0; $y < $this->heigth; ++$y) {
            $row = [];
            for($x = 0; $x < $this->width; ++$x) {
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
    function countLivingNeighbors($x, $y)
    {
        //Analyzing the living/dead neighboors
        $coordinates = [
            [-1, -1], [-1, 0], [-1, 1],
            [0, -1], [0, 1],
            [1, -1], [1, 0], [1, 1]
        ];
        $count = 0;


        foreach($coordinates as $coordinate)
        {
            if(isset($this->board[$x + $coordinate[0]][$y + $coordinate[1]])
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

        foreach($this->board as $widthID => $width)
        {
            $newBoard[$widthID] = [];
            foreach($width as $heigthID => $heigth)
            {
                $count = $this->countLivingNeighbors($widthID, $heigthID);

                $newValue=null;
                if($heigth == 1)
                {
                    if($count < 2 || $count > 3)
                    {
                        $newValue=0;
                    } else
                    {
                        $newValue=1;
                    }
                } else
                {
                    if($count == 3)
                    {
                        $newValue = 1;
                    }
                }

                $newBoard[$widthID][$heigthID] = $newValue;
            }
        }

        $this->board = $newBoard;
    }

    /**
     *
     * A glider function wich runs/glides through the whole board.
     */
    function createGlider()
    {
        for($y = 0; $y < $this->heigth; ++$y) {
            $row = [];
            for($x = 0; $x < $this->width; ++$x) {
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
       for($y = 0; $y < $this->heigth; ++$y)
       {
           for($x = 0; $x < $this->width; ++$x)
           {
               //the dead cells
               $liveOrdead= 0;
               if($this->board[$x][$y] == 1)

                   //living cells
                   $liveOrdead=1;
                   echo $liveOrdead;

           }
           echo "\n";
       }
    }
}
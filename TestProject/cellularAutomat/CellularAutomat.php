<?php

class CellularAutomat
{
    public $heigth;
    public $width;
    public $board = [0, 1, 2, 3, 4, 5, [0, 1, 2, 3, 4, 5]];

    /**
     * @param $_heigth
     * @param $_width
     */
    function __construct($_heigth, $_width)
    {
        $this->heigth=$_heigth;
        $this->width=$_width;
    }

    /**
     * Creation of the board which consists of cells and set as rows and cols
     */
    function createBoard(){
        for($y = 0; $y < $this->width; $y++) {
            $row = [];
            for($x = 0; $x < $this->heigth; $x++) {
                $row[$x] = rand(0,1);
            }
        }
        $this->board[$y] = $row;
    }

    /**
     * @param $x
     * @param $y
     * @return int
     *
     * The living and dead neighbors will be counted around the base cell
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
     * On base of the living and dead neighbors, the next generation will be created
     */
    function calculateNextGeneration() {
        $newBoard= [];

        foreach($this->board as $widthID => $width)
        {
            $newBoard[$widthID] = [];
            foreach ($width as $heightID => $height)
            {
                $count = $this->countLivingNeighbors($widthID, $heightID);

                $newValue=null;
                if($height == 1)
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

                $newBoard[$widthID][$heightID] = $newValue;
            }
        }
    }

    /**
     *
     * Creation of a glider which runs/glids thorugh the board
     */
    function createGlider()
    {
        for($y = 0; $y < $this->width; $y++) {
            $row = [];
            for($x = 0; $x < $this->heigth; $x++) {
                $row[$x] = rand(0,1);
            }
        }
        $this->board[$y] = $row;

        $this->board[1][0]=1;
        $this->board[2][1]=1;
        $this->board[2][2]=1;
        $this->board[1][2]=1;
        $this->board[0][2]=1;
    }

    /**
     * Output of the whole Board with the cells; 1 stands for living cells and 0 stands for dead cells
     */
    function printOutBoard()
    {
       for($y = 0; $y < $this->width; $y++)
       {
           for($x = 0; $x < $this->heigth; $x++)
           {
               $liveOrdead= 0;
               if($this->board[$x][$y] == 1)
               {
                   $liveOrdead=1;
                   echo $liveOrdead;
               }
           }
           echo "\n";
       }
    }
}
<?php

namespace input;

use input\Base;
use cellularAutomat\Board;
use options\Getopt;

/**
 * The User can set a cell alive over a specific command in the command line.
 *
 * To do so an empty board is given where the user have to set the coordinates over the command line
 * so the given cell coordinate is set alive but all the other cells are dead.
 *
 * @class User
 */
class User extends Base
{
    /**
     * Prepares an empty board where the coordinates for the x/-axis has to be given, so the wished
     * cell is set on alive but the rest cells are dead.
     *
     * CL-example: php gameoflife.php -i User 3,6
     *
     * After the user set the coordinates, type -> finish so the process can be executed.
     *
     * @param Board $_board
     * @param Getopt $_options
     */
    public function fillBoard(Board $_board, Getopt $_options)
    {
        echo "Enter the coordinates for the x/y-axis like in the following example: -i User 3,6 (Enter)
              After set the coordinates type -> finish to run the process.";

        while (true)
        {
            $commandLineInput = readline("Enter the coordinate for the x/y-axis: ");

            if ($commandLineInput == "finish") break;

            $startCoordinates = explode(",", $commandLineInput);

            if (count($startCoordinates) == 2)

                for ($y = 0; $y < $_board->getHeight(); ++$y)
                {
                    for ($x = 0; $x < $_board->getWidth(); ++$x)
                    {
                        $_board->setCell($startCoordinates[0], $startCoordinates[1], 1);
                    }
                }
        }

    }
}
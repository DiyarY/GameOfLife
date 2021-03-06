<?php

namespace output;

use options\Getopt;
use cellularAutomat\Board;

/**
 * Shows the output of the current board over the console.
 *
 * @class ConsoleOutput
 */
class ConsoleOutput extends BaseOutput
{

    /**
     * Shows the output of the current board over the console.
     *
     * @param Board $_board Presents the current board.
     */
    function outputBoard(Board $_board)
    {
        $board = $_board->getBoard();

        for ($y = 0; $y < $_board->getHeight(); ++$y) {
            for ($x = 0; $x < $_board->getWidth(); ++$x) {
                $currentBoard = $board[$x][$y] ? " * " : " - ";
                echo $currentBoard;
            }
            echo "\n";
        }
        echo "\n";
    }
}
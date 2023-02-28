<?php
namespace GameOfLife\output;

use GameOfLife\cellularAutomat\Board;

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
        $board = $_board->getFieldBoard();

        for ($y = 0; $y < $_board->height(); ++$y) {
            for ($x = 0; $x < $_board->width(); ++$x) {
                echo $board[$x][$y] ? "*" : "-";
            }
            echo "\n";
        }
        echo "\n";
    }
}
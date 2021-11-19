<?php
namespace input;

use input\Base;

use options\Getopt;
use  cellularAutomat\Board;

/**
 * Catches the created board with the given values for height and width and creates the glider inside the board
 * where only the glider can be seen.
 *
 * Furthermore, if the option "gliderPosition" is used in the CL, the start position of the glider can be set
 * manually.
 *
 * @class
 */
class Glider extends Base
{
    /**
     * Starts the glider, where only the glider can be seen (only the living cells)(CL-command: --input Glider)
     *
     * @param Board $_board
     * @param Getopt $_options
     */
    function fillBoard(Board $_board, GetOpt $_options)
    {
        $x = round($_board->getWidth() / 2 - 0.6);
        $y = round($_board->getHeight() / 2 - 0.6);

        if ($_options->getOption("gliderPosition"))
        {
            $arguments = explode(',', $_options->getOption("gliderPosition"));
            $x = $arguments[0];
            $y = $arguments[1];
        }

        $_board->setCell($x + 1, $y + 0, 1);
        $_board->setCell($x + 2, $y + 1, 1);
        $_board->setCell($x + 0, $y + 2, 1);
        $_board->setCell($x + 1, $y + 2, 1);
        $_board->setCell($x + 2, $y + 2, 1);
    }

    /**
     * Adds a required-option, which sets the glider in the given position, which has to be given inside
     * the CL (-g 4,5 --input Glider).
     *
     * @param Getopt $_options
     */
    function addOptions(Getopt $_options)
    {
        $_options->addOptions(
            [
                ['g', "gliderPosition", Getopt::REQUIRED_ARGUMENT, " Sets the glider on position x/y"]
            ]);
    }

}

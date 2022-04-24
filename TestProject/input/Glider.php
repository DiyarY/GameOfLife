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
            //Startpoint coordinates (x/y-axis) for the glider
            list($x,$y) = explode(',',$_options->getOption("gliderPosition"));

        $_board->setCell($x + 1, $y + 0, 1);
        $_board->setCell($x + 2, $y + 1, 1);
        $_board->setCell($x + 0, $y + 2, 1);
        $_board->setCell($x + 1, $y + 2, 1);
        $_board->setCell($x + 2, $y + 2, 1);
    }

    /**
     * The user has to enter a required option to set the start position of the glider.
     * The needed numbers are marked as start coordinates for the x,y position.
     *
     * User input over the CL: "-g 3,2 --input Glider".
     * 3 marks the x coordinate and 2 the y coordinate.
     *
     * @param Getopt $_options
     */
    function addOptions(Getopt $_options)
    {
        $_options->addOptions(
            [
                ['g', "gliderPosition", Getopt::REQUIRED_ARGUMENT, " Set the start position of the glider on the coordinates x,y -> CLI-command: \"-g 10,10\" or \"--gliderPosition 10,10\""]
            ]);
    }

}

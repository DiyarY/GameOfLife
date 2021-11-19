<?php
namespace input;

use input\Base;

use cellularAutomat\Board;
use options\Getopt;

/**
 * Creates a random board with living/death cells.
 *
 * By use of the required-option the filling level (living/death cells) can be set manually.
 *
 * @class Random
 */
class Random extends Base
{
    /**
     * Creates a Random Board with living/death cells.
     *
     * @param Board $_board
     * @param Getopt $_options
     */
    function fillBoard(Board $_board, Getopt $_options)
    {
        $fillingRange = null;
        if ($_options->getOption("fillingLevel"))
            $fillingRange = intval($_options->getOption("fillingLevel"));

        for ($y = 0; $y < $_board->getHeight(); ++$y)
        {
            for ($x = 0; $x < $_board->getWidth(); ++$x)
            {
                if ($_options->getOption("fillingLevel"))
                    $_board->setCell($x, $y, rand(0, 99) < $fillingRange);

                else if ($_options->getOption("input"))
                    $_board->setCell($x, $y, rand(0, 1));
            }
        }
    }

    /**
     * Sets the filling level of the board (CL-command: -f 100 --input Random).
     *
     * @param Getopt $_options
     */
    function addOptions(Getopt $_options)
    {
        $_options->addOptions(
            [
                ['f', "fillingLevel", Getopt::REQUIRED_ARGUMENT, " Sets the filling number of living cells"]
            ]);
    }
}
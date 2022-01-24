<?php

namespace output;

use options\Getopt;
use cellularAutomat\Board;

class ConsoleOutput extends BaseOutput
{
    function outputBoard(Board $_board)
    {
        for ($y = 0; $y < $_board->getHeight(); ++$y) {
            for ($x = 0; $x < $_board->getWidth(); ++$x) {
                $_board->setCell($x, $y, rand(0, 1));
            }
        }
    }
}
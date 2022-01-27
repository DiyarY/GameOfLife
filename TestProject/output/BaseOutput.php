<?php
namespace output;

use options\Getopt;
use cellularAutomat\Board;

/**
 * BaseOutput class which provides the functions for pluggable-output.
 *
 * @class BasOutput
 */
class BaseOutput
{
    /**
     * @var int creates a new image*.png after every run.
     */
    protected $imageIndex = 0;

    /**
     * Provides additional options.
     *
     * @param Getopt $_options
     */
    function addOptions(Getopt $_options)
    {
    }

    /**
     * Calls a single file.
     *
     * @param Getopt $_options
     */
    function startOutput(Getopt $_options)
    {
    }

    /**
     * Prints out the board.
     *
     * @param Board $_board
     */
     function outputBoard(Board $_board)
     {
     }

    /**
     *
     */
    function finishOutput()
    {
    }
}
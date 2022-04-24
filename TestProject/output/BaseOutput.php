<?php
namespace output;

use options\Getopt;
use cellularAutomat\Board;

/**
 * BaseOutput provides functions for pluggable outputs.
 *
 * /"addOptions(Getopt $_options)/" allows an output to define additional, output specific options.
 *
 * /"startOutput(Getopt $_options)/" initialize and starts the respective output.
 *
 * /"outputBoard(Board $_board)/" prints out the current board.
 *
 * /"finishOutput(Getopt $_options)/" finishes the output of a gif-animation.
 *
 * @class BasOutput
 */
abstract class BaseOutput
{
    /**
     * Allows an output to define additional, output specific options, that can be passed as required command-line
     * argument.
     *
     * @param Getopt $_options Option manager to define output-specific options.
     */
    function addOptions(Getopt $_options)
    {
    }

    /**
     * Makes it possible to initialize and create the correct output with their output-specific options,
     * passed as command-line arguments.
     *
     * @param Getopt $_options Option manager, to check for the correct output with their required options.
     */
    function startOutput(Getopt $_options)
    {
    }

    /**
     * Shows all generations of the board through the console/terminal.
     *
     * Creates for each generation of a bord an image in png-format.
     *
     * @param Board $_board Prepares the current board
     */
     function outputBoard(Board $_board)
     {
     }

    /**
     * Stops the running process of an output. An example could be the running process of a video, which has to finish
     * its output after a specified running-time.
     */
    function finishOutput()
    {
    }
}
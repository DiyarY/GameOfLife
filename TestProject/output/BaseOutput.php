<?php
namespace output;

use options\Getopt;
use cellularAutomat\Board;

/**
 * To run one of the three classes - not BaseOutput.php - use following commands over the command line:
 * \"--output PNGOutput\"   \"--output GifOutput\"   \"--output ConsoleOutput\"
 *
 * To print the current created board, \"outputBoard(Board $_board) must\"
 * be used which is defined under -> ConsoleOutput.
 *
 * To implement an image in png-format, \"outputBoard(Board $_board)\" must be used by help
 * of the gd-library, which provides the needed functions to create and customise an image, which is defined
 * under -> PNGOutput.
 *
 * To implement an animated gif of the board, \"finishOutput()\" must be used which is defined
 * under -> GifOutput.
 *
 * \"startOutput(Getop $_options)\" makes it possible to initialize and create the correct output. In addition, it checks
 * for required options, passed as command-line arguments when running gameoflife.
 *
 * To implement additional, output-specific options, \"addOptions(Getopt $_options)\" must be used. These options can
 * be passed as command-line arguments for all outputs, that requires an option.
 *
 * @class BasOutput
 */
class BaseOutput
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
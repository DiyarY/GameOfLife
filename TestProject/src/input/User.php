<?php
namespace GameOfLife\input;

use GameOfLife\cellularAutomat\Board;
use GameOfLife\options\Getopt;

/**
 * The user is prompted to enter cells that are alive.
 *
 * To do so an empty board is given where the user have to set the coordinates over the command line
 * so the given cell coordinate is set alive but all the other cells are dead.
 *
 * @class User
 */
class User extends Base
{
    /**
     * Prepares an empty board where the coordinates for the x/-axis has to be entered, so the wished
     * cell can be set as living cell where the rest are staying dead.
     *
     * While the process is running, the user will be asked to enter the coordinates which could look
     * like the following example: 3,3 \Enter\.
     *
     * After the user set the coordinates, type -> finish - to execute the process.
     *
     * @param Board $_board
     * @param Getopt $_options
     */
    public function fillBoard(Board $_board, Getopt $_options)
    {
        echo "Enter the coordinates for the x/y-axis. 
              Example: 3,6 \"Enter\" - the cell on the x-coordinate: 3 and y:-coordinate: 6 is set alive(1), while the rest is set dead(0). 
              After set the coordinates type -> finish \"Enter\" - so the process can be executed.\n";

        while (true) {

            $commandLineInput = readline("Enter the coordinate for the x/y-axis: ");

            if ($commandLineInput == "finish") break;

            $startCoordinates = explode(",", $commandLineInput);

            /*
             * Runs through the $startCoordinates array to check whether it contains a numerical string, where the
             * first numerical-string-value represents the x-coordinate and the second the y-coordinate.
             *
             * If the user enters a string instead of two integers for the x/y-coordinate, which are seperated by a comma,
             * a warning message is printed, with an example how the coordinates actually should be set.
             */
            foreach ($startCoordinates as $coordinate) {
                //Checks for a numerical string
                if (ctype_digit($coordinate)) {
                    //Given coordinates for the x/y-axis is set on alive(1)
                    if (count($startCoordinates) == 2) {
                        $_board->setCell($startCoordinates[0], $startCoordinates[1], 1);
                    }
                } //Prints a warning message with an example how the coordinates actually should be set
                else if (filter_var($coordinate, FILTER_SANITIZE_STRING)) {
                    echo "WARNING! Please enter two integer numbers for the x/y coordinate, for instance like that -> 3,3 \"Enter\"\n";
                    error_reporting(E_ERROR);
                    break 2;
                }
            }
        }
    }
}
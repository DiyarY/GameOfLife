<?php
namespace input;

use options\Getopt;
use cellularAutomat\Board;

/**
 * Base class for pluggable inputs.
 *
 * Fills the created board with the given height and width values.
 *
 * Adds additional options for pluggable input.
 *
 * @class BaseInput
 */
abstract class Base
{
    /**
     * Adds additional option which can be called over input.
     *
     * @param Getopt $_options
     */
    function addOptions(Getopt $_options)
    {
    }

    /**
     * Catches the created board.
     *
     * @param Board $_board
     * @param Getopt $_options
     */
    abstract function fillBoard(Board $_board, Getopt $_options);
}
<?php
namespace input;

use options\Getopt;
use cellularAutomat\Board;

/**
 *
 *
 * @class BaseInput
 */
class BaseInput
{
    public $options = [];
    public $board = [[]];

    /**
     * @param Getopt $_options
     */
    function addOptions(Getopt $_options)
    {
        $this->options[]=$_options;
    }

    /**
     * @param Board $_board
     * @param Getopt $_options
     */
    function fillBoard(Board $_board, Getopt $_options)
    {
        $this->options[]=$_options;
        $this->board[]=$_board;
    }
}
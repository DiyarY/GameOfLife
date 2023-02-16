<?php
namespace GameOfLife\Rules;

use GameOfLife\options\Getopt;
use GameOfLife\cellularAutomat\Field;

/**
 * API-class for additional rules.
 */
abstract class BaseRule
{
    /**
     * @param Field $_field The cell which is going to be checked.
     * @return bool The new state of the given field in the next generation
     */
    public function calculateNewState(Field $_field)
    {
    }

    /**
     * Add rule specific-options to the option list.
     *
     * @param Getopt $_options option list.
     * @return void
     */
    public function addOptions(Getopt $_options)
    {
    }

    /**
     * Initializes the rule.
     *
     * @param Getopt $_options option list
     * @return void
     */
    public function initialize(Getopt $_options)
    {
    }
}
<?php
namespace GameOfLife\Rules;

use GameOfLife\options\Getopt;
use GameOfLife\cellularAutomat\Field;

/**
 * Base Rule for all rule implementations.
 */
abstract class BaseRule
{
    /**
     * @param Field $_field The cell which is going to be checked.
     * Hint: /"Field $_field/" provides a constructor with the parent-board, x- & y-coordinates and also prevents an out of border count.
     * @return bool The new state of the given field in the next generation
     */
    abstract public function calculateNewState(Field $_field);

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
     * Initialize the rule-implementation.
     *
     * This defines the needed rule, on what the logical appearance of the board will be based on.
     *
     * Before the execution process, the specific rule implementation must bes set, example: --rule StandardRule,
     * which will execute the game logic after the standard-rule.
     *
     * @param Getopt $_options option list
     * @return void
     */
    public function initialize(Getopt $_options)
    {
    }
}
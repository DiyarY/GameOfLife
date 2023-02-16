<?php
namespace GameOfLife;

use GameOfLife\Rules\BaseRule;
use GameOfLife\cellularAutomat\Board;

/**
 * Handles the logic of the game which must be set during the before the execution process.
 *
 * Call calculate calculateNextBoard($_board) to calculate a game step for the entire board.
 */
class GameLogic
{
    private $rule;
    /** @var Board[] */
    private $previousGenerations = [];
    /** @var Board */
    private $currentGeneration;

    /**
     * GameLogic constructor.
     *
     * @param BaseRule $_rule Rule for the next calculated generation.
     */
    public function __construct(BaseRule $_rule)
    {
        $this->rule = $_rule;
    }

    /**
     * Calculates the next generation of the board based on the applied rule implementation.
     *
     * @param Board $_board current board.
     */
    public function calculateNextGeneration(Board $_board): Board
    {
        $newGeneration = new Board($_board->getHeight(), $_board->getWidth());
        $this->previousGenerations[] = $_board;

        for ($x = 0; $x < $_board->getWidth(); $x++)
        {
            for ($y = 0; $y < $_board->getHeight(); $y++)
            {
                $cell = $_board->cell($x, $y);
                $newGeneration->setCell($x, $y, $this->rule->calculateNewState($cell));
            }
        }
        $this->currentGeneration = $newGeneration;
        return $newGeneration;
    }

    /**
     * Checks if the new generated board is equal to the previous ones.
     *
     * @return bool Determines whether there's a similarity between the previous boards and the current board.
     */
    public function isLoopDetected(): bool
    {
        foreach ($this->previousGenerations as $previousGeneration)
        {
            if ($this->currentGeneration->getFieldBoard() == $previousGeneration->getFieldBoard()) return true;
        }
        return false;
    }
}
<?php
namespace GameOfLife\Rules;

use GameOfLife\cellularAutomat\Field;

/**
 * The standard rule of conways game of life.
 */
class StandardRule extends BaseRule
{
    /**
     * @param Field $_field Respective cell which is going to be checked for.
     * @return bool state of the cell.
     */
    public function calculateNewState(Field $_field): bool
    {
        $numberOfLivingNeighbours = $_field->numberOfLivingNeighbors();
        if ($_field->isDead())
        { //cell is dead
            if ($numberOfLivingNeighbours==3) return true;
        }
        else
        { //Cell is living
            if ($numberOfLivingNeighbours < 2 ) return false;
            if ($numberOfLivingNeighbours == 2 || $numberOfLivingNeighbours == 3) return true;
            if ($numberOfLivingNeighbours > 3) return false;
        }
        return false;
    }
}
<?php
namespace GameOfLife\Rules;

use GameOfLife\cellularAutomat\Field;

/**
 * This Rule creates a certain pattern which will b spin in 245 degree.
 */
class Two45Rule extends BaseRule
{
    /**
     * @param Field $_field Respective cell which is going to be checked for.
     * @return bool state of the cell.
     */
    public function calculateNewState(Field $_field): bool
    {
        $numberOfLivingNeighbors = $_field->numberOfLivingNeighbors();
        if ($numberOfLivingNeighbors == 0 || $numberOfLivingNeighbors == 1 ||
            $numberOfLivingNeighbors == 3 || $numberOfLivingNeighbors == 6 ||
            $numberOfLivingNeighbors == 7 || $numberOfLivingNeighbors == 8)
        {
            return false;
        }
        elseif ($numberOfLivingNeighbors == 2 || $numberOfLivingNeighbors == 4 ||
            $numberOfLivingNeighbors == 5)
        {
            return true;
        }
        return false;
    }
}
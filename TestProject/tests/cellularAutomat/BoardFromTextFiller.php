<?php
namespace Tests\CellularAutomat;

use GameOfLife\cellularAutomat\Board;

/**
 * BoardFromTextFiller represents the board in string-format.
 */
class BoardFromTextFiller
{
    /**
     * Returns board as array.
     *
     * @param Board $_bord Current Board.
     * @param string $_text Returns an array of strings.
     * @return void
     */
    function fillBoardFromText(Board $_bord, string $_text)
    {
        echo "\n\n";
        $textLines=explode("\n",$_text);
        $currentX = 0;
        $currentY = 0;

        foreach ($textLines as $currentLine)
        {
            for ($i=0; $i<strlen($currentLine); $i++)
            {
                $currentChar = $currentLine[$i];
                if ($currentChar=="*" || $currentChar == "-")
                {
                    if ($currentChar == "*") $_bord->setCell($currentX,$currentY,true);
                    else $_bord->setCell($currentX,$currentY,false);
                    $currentX++;
                }
            }
            $currentX=0;
            $currentY++;
        }
    }
}
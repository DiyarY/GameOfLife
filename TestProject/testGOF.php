<?php

require_once "cellularAutomat\CellularAutomat.php";

$sizeRangeOfBoard = 100;

$createCellularAutomat = new CellularAutomat(5, 5);
$createCellularAutomat->createBoard();

for($i = 0; $i < $sizeRangeOfBoard; $i++)
{
    echo "Generation: ".$i."\n";
    $createCellularAutomat->printOutBoard();
    $createCellularAutomat->calculateNextGeneration();
}
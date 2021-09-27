<?php

require_once "CellularAutomat.php";

$sizeRangeOfBoard = 1;

$createCellularAutomat = new CellularAutomat(5, 5);
$createCellularAutomat->createBoard();

for($i = 0; $i < $sizeRangeOfBoard; $i++)
{
    echo "Generation: ".$i."\n";
    $createCellularAutomat->printOutBoard();
    $createCellularAutomat->calculateNextGeneration();
}
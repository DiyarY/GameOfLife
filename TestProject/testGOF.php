<?php
require_once "CellularAutomat.php";

/**
 * Total number of rows and cols
 */
$createCellularAutomat = new CellularAutomat(8, 8);
$createCellularAutomat->createBoard();

for($i = 0; $i < 5; $i++)
{
    echo "\nVersion: ".$i."\n";
    $createCellularAutomat->printOutBoard();
    $createCellularAutomat->calculateNextGeneration();
}
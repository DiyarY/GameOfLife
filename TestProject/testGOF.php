<?php
require_once "CellularAutomat.php";

/**
 * Total number of rows and cols
 */
$createCellularAutomat = new CellularAutomat(10, 10);
$createCellularAutomat->createBoard();

//Configure the generations
for($i = 0; $i < 2; $i++)
{
    //Print out the generations
    echo "\nVersion: ".$i."\n";
    $createCellularAutomat->printOutBoard();
    $createCellularAutomat->calculateNextGeneration();
}
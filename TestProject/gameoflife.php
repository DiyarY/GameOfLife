<?php
use cellularAutomat\Board;
use options\Getopt;


/**
 * Function for Autoloader.
 * @param $className
 */
function myAutoload($className) {
    $classPath = str_replace("\\", "/", $className);
    require_once(sprintf("%s/%s.php", __DIR__, $classPath));
}

/**
 * Excecution of the autoloader
 */
spl_autoload_register("myAutoload");


/**
 * Command line parameters
 */
$options = new Getopt([['r', "startRandom", Getopt::NO_ARGUMENT, "Starts the board with random cells which are dead/alive"],
                        ['g', "startGlider", Getopt::NO_ARGUMENT, "Starts the board with a glider which runs through the board"],
                        ['w', "width", Getopt::REQUIRED_ARGUMENT, "Sets the width of the board"],
                        ['h', "heigth", Getopt::REQUIRED_ARGUMENT, "Sets the height of the board"],
                        ['s', "maxSteps", Getopt::NO_ARGUMENT, "Sets the number of the generations"],
                        ['v', "version", Getopt::NO_ARGUMENT, "Shows the version"],
                        ['h', "help", Getopt::NO_ARGUMENT, "Shows a help/guide menu"]]);

/**
 * Evaluate the given Arguments which can be parsed either as an array or string
 */
$options->parse();


if($options->getOptions("help"))
{
    $options->showHelp();
}

if($options->getOption("version"))
{
    echo "Version: 1.0\n";
}

/**
 * Set the total number for each row and col.
 */
$width = 5;
$height = 5;
if($options->getOptions("width"))
{
    $width = $options->getOptions("width");
}

if($options->getOptions("height"))
{
    $height = $options->getOptions("height");
}

/**
 * Total number of generations.
 */
$maxSteps = 5;
if($options->getOptions("maxSteps"))
{
    echo $maxSteps;
}

/**
 * Decleration of an instance of the class Board which has two given parameters of the total number for each row and col
 * @class Board
 */
$startBoard = new Board($width, $height);

if($options->getOptions("startRandom"))
{
    $startBoard->createBoard();
}

if($options->getOptions("startGlider"))
{
    $startBoard->createGlider();
}


$startBoard->createBoard();

/**
 * Starts the board together with all generated generations.
 * If the Board reached the end of the set generations the game is over
 */
for($i = 0; $i < $maxSteps; $i++)
{
    echo "\nGeneration: ".$i."\n";
    $startBoard->printOutBoard();
    $startBoard->calculateNextGeneration();

    if($i == $maxSteps)
    {
        break;
    }
}
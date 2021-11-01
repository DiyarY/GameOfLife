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
 * Execution of the autoloader
 */
spl_autoload_register("myAutoload");


/**
 * Command line parameters
 */
$options = new Getopt([['r', "startRandom", Getopt::NO_ARGUMENT, "Starts the board with random cells which are dead/alive"],
                        ['g', "startGlider", Getopt::NO_ARGUMENT, "Starts the board with a glider which runs through the board"],
                        ['w', "width", Getopt::REQUIRED_ARGUMENT, "Sets the width of the board"],
                        ['e', "height", Getopt::REQUIRED_ARGUMENT, "Sets the height of the board"],
                        ['s', "maxSteps", Getopt::REQUIRED_ARGUMENT, "Sets the number of the generations"],
                        ['v', "version", Getopt::NO_ARGUMENT, "Shows the version"],
                        ['h', "help", Getopt::NO_ARGUMENT, "Shows a help/guide menu"]]);

/**
 * Evaluate the given Arguments which can be parsed either as an array or string
 */
$options->parse();


if ($options->getOption("help"))
{
    $options->showHelp();
    die;
}

if ($options->getOption("version"))
{
    echo "Version: 1.0\n";
    die;
}

/**
 * Set the total number for each row and col.
 */
$width = 5;
$height = 5;
if ($options->getOption("width"))
{
    $width = $options->getOption("width");
}

if ($options->getOption("height"))
{
    $height = $options->getOption("height");
}

/**
 * Total number of generations.
 */
$maxSteps = 7;
if ($options->getOption("maxSteps"))
{
    $maxSteps = $options->getOption("maxSteps");
}

/**
 * Declaration of an instance of the class Board which has two given parameters of the total number for each row and col
 *
 * @class Board
 */
$board = new Board($width, $height);

if ($options->getOption("startRandom"))
{
    $board->createBoard();
}

if ($options->getOption("startGlider"))
{
    $board->createGlider();
}

$board->createBoard();

/**
 * Starts to create the number of generations, which are set in "maxSteps".
 *
 * The Board stops to generate a next generation if it reached the last number of "maxSteps".
 *
 * The Board stops to generate a next generation if it's similar to the next one.
 */
for ($i = 0; $i < $maxSteps; $i++)
{
    echo "\nGeneration: ".$i."\n";
    $board->printOutBoard();
    $board->calculateNextGeneration();

    if ($board->checkBoardOnSimilarities() == true) break;
}
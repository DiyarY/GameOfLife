<?php
use cellularAutomat\Board;
use options\Getopt;

use input\Base;
use input\Glider;
use input\Random;

$width = 10;
$height = 10;
$maxSteps = 20;

/**
 * @param $className
 */
function myAutoload($className) {
    $classPath = sprintf("%s/%s.php", __DIR__, str_replace("\\", "/", $className));
    if (is_readable($classPath)) require_once($classPath);
}

/**
 * Register the autoloader.
 */
spl_autoload_register("myAutoload");

$options = new Getopt(
    [
        ['i', "input", Getopt::REQUIRED_ARGUMENT, " Which input should be used to fill the board"],
        ['w', "width", Getopt::REQUIRED_ARGUMENT, "Sets the width of the board"],
        ['e', "height", Getopt::REQUIRED_ARGUMENT, "Sets the height of the board"],
        ['s', "maxSteps", Getopt::REQUIRED_ARGUMENT, "Sets the number of the generations"],
        ['v', "version", Getopt::NO_ARGUMENT, "Shows the version"],
        ['h', "help", Getopt::NO_ARGUMENT, "Shows a help/guide menu"]
    ]);

/**
 * The glob function finds all register all filenames inside
 * the input directory.
 */
$files = glob("input/*.php");

foreach ($files as $file)
{
    $baseClassName = basename($file, ".php");
    $className = "input\\$baseClassName";

    if ($className == Base::class) continue;

    if (class_exists($className))
    {
        $input = new $className;
        if ($input instanceof Base)
        {
            $input->addOptions($options);
        }
    }
}


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

if ($options->getOption("width"))
{
    $width = $options->getOption("width");
}

if ($options->getOption("height"))
{
    $height = $options->getOption("height");
}

if ($options->getOption("maxSteps"))
{
    $maxSteps = $options->getOption("maxSteps");
}


$board = new Board($width, $height);

$requestedInput = $options->getOption("input") ?? "Random";
$className="input\\$requestedInput";

if (class_exists($className))
{
    $input = new $className;
    if ($input instanceof Base)
    {
        $input->fillBoard($board, $options);
    }
    else die ("Requested input $requestedInput does not inherit from input\\Base!\n");
}
else die ("Could not find input $requestedInput!\n");


for ($i = 0; $i < $maxSteps; $i++)
{
    echo "\nGeneration: ".$i."\n";
    $board->printOutBoard();
    $board->calculateNextGeneration();

    if ($board->checkBoardOnSimilarities() == true) break;
}
#!/usr/bin/php
<?php

use cellularAutomat\Board;
use options\Getopt;
use input\Base;
use output\BaseOutput;

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
        ['o', "output", Getopt::REQUIRED_ARGUMENT, "Which output should be used"],
        ['w', "width", Getopt::REQUIRED_ARGUMENT, "Sets the width of the board"],
        ['e', "height", Getopt::REQUIRED_ARGUMENT, "Sets the height of the board"],
        ['s', "maxSteps", Getopt::REQUIRED_ARGUMENT, "Sets the number of the generations"],
        ['v', "version", Getopt::NO_ARGUMENT, "Shows the version"],
        ['h', "help", Getopt::NO_ARGUMENT, "Shows a help/guide menu"]
    ]);


/*
 * To ensure that the options Glider and Random can be set inside the command line -
 * (--input Glider / --input Random) - it's important that the classname matches with the set
 * command, otherwise the command can't be executed.
 */

//The classes inside the input directory are going  to initialize and returned as array values
$files = glob("input/*.php");

//Runs through the whole input path and initialize the class-files
foreach ($files as $file)
{
    //Removes the datatype -> .php from the class file
    $baseClassName = basename($file, ".php");
    //Initializing the input path with their class files but without their respective datatype -> .php
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

/*
 * To ensure that the options gifCellSize and gifCellColor can be set inside the command line ->
 * \"--output GifOutput\" - it's important that the classname matches with the set
 * command, otherwise the option can't be executed.
 */

//The classes inside the output directory are going to be initialized and returned as array values
$filesInOutput = glob("output/*.php");

//Runs through the whole output path and initialize the class.php files
foreach ($filesInOutput as $file)
{
    //Removes the datatype -> .php from the class file
    $baseClassName = basename($file, ".php");
    //Initialize the output path with its class files but without respective data-format -> .php
    $className = "output\\$baseClassName";

    if ($className == BaseOutput::class) continue;

    if (class_exists($className))
    {
        $output = new $className;
        if ($output instanceof BaseOutput)
        {
            $output->addOptions($options);
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


//Initialize and return the defined classes inside the output directory
$requestedOutput = $options->getOption("output") ?? "ConsoleOutput";
$classNameForOutput = "output\\$requestedOutput";

if (class_exists($classNameForOutput))
{
    $output = new $classNameForOutput;
    if ($output instanceof BaseOutput)
    {
        $output->startOutput($options);
    }
    else die ("Requested output $requestedOutput doesn't inherit from output\\BaseOutput!\m");
}
else die ("Could not find output $requestedOutput!\n");


for ($i = 0; $i < $maxSteps; $i++)
{
    echo "\nGeneration: ".$i."\n";
    $output->outputBoard($board);
    $board->calculateNextGeneration();

    if ($board->checkBoardOnSimilarities() == true) break;
}

$output->finishOutput();
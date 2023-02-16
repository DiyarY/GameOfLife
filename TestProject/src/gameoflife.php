#!/usr/bin/php
<?php
namespace GameOfLife;

use GameOfLife\cellularAutomat\Board;
use GameOfLife\options\Getopt;
use GameOfLife\input\Base;
use GameOfLife\output\BaseOutput;
use GameOfLife\Rules\BaseRule;

$width = 10;
$height = 10;
$maxSteps = 65;
$rule = null;

require_once "../vendor/autoload.php";

$options = new Getopt(
    [
        ['i', "input", Getopt::REQUIRED_ARGUMENT, " Which input should be used to fill the board"],
        ['o', "output", Getopt::REQUIRED_ARGUMENT, "Which output should be used"],
        ['w', "width", Getopt::REQUIRED_ARGUMENT, "Sets the width of the board"],
        ['e', "height", Getopt::REQUIRED_ARGUMENT, "Sets the height of the board"],
        ['s', "maxSteps", Getopt::REQUIRED_ARGUMENT, "Sets the number of the generations"],
        ['v', "version", Getopt::NO_ARGUMENT, "Shows the version"],
        ['h', "help", Getopt::NO_ARGUMENT, "Shows a help/guide menu"],
        ['r', "rule", Getopt::REQUIRED_ARGUMENT, "Used to specify the rule to use"]
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
    $className = "GameOfLife\\input\\$baseClassName";

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
    $className = "GameOfLife\\output\\$baseClassName";

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

//The classes inside the rule-directory are going to be initialized and returned as array values.
$filesInRules = glob("rules/*.php");

//Iterates through the whole rule-path and initializes the class.php files.
foreach ($filesInRules as $filesInRule)
{
    //Removes the datatype
    $baseClassName = basename($filesInRule, ".php");
    $className = "GameOfLife\\Rules\\$baseClassName";

    if ($className == BaseRule::class) continue;

    if (class_exists($className))
    {
        $rule = new $className;
        if ($rule instanceof BaseRule)
        {
            $rule->addOptions($options);
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

//Initialize and returns the defined input-class inside the input-directory.
$requestedInput = $options->getOption("input") ?? "Random";
$className="GameOfLife\\input\\$requestedInput";

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


//Initialize and returns the defined output-class inside the output-directory.
$requestedOutput = $options->getOption("output") ?? "ConsoleOutput";
$classNameForOutput = "GameOfLife\\output\\$requestedOutput";

if (class_exists($classNameForOutput))
{
    $output = new $classNameForOutput;
    if ($output instanceof BaseOutput)
    {
        $output->startOutput($options);
    }
    else die ("Requested output $requestedOutput doesn't inherit from output\\BaseOutput!\n");
}
else die ("Could not find output $requestedOutput!\n");


//Initialize and returns the defined rule-class inside the rule-directory.
$requestedRule = $options->getOption("StandardRule") ?? "CopyRule";
$classNameRule = "GameOfLife\\rules\\$requestedRule";

if (class_exists($classNameRule))
{
    $rule = new $classNameRule;

    if ($rule instanceof BaseRule)
    {
        $rule->initialize($options);
    }
    else die ("Requested rule $requestedRule doesn't inherit from rule\\BaseRule!\n");
}
else die ("Could not find rule $requestedRule!\n");


$gameLogic = new GameLogic($rule);

for ($i = 0; $i < $maxSteps; $i++)
{
    echo "\nGeneration: ".$i."\n";
    $output->outputBoard($board);
    $board = $gameLogic->calculateNextGeneration($board);

    if ($gameLogic->isLoopDetected()) {
        echo "Loop detected, aborting!\n";
        break;
    }
}
$output->finishOutput();
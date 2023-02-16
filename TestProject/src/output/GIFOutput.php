<?php
namespace GameOfLife\output;

use GameOfLife\options\Getopt;
use GameOfLife\cellularAutomat\Board;
use GameOfLife\GifAnimation\GifCreator;

/**
 * An animated gif-file is automatically created by hand of the created images from the board.
 *
 * @class GifOutput
 */
class GIFOutput extends BaseOutput
{
    /**
     * @var int $imageIndex Index-number of image.
     * @var int $cellSize Size of the cell.
     * @var int[] $gifCellColor RGB-color.
     */
    private $imageIndex = 0;
    private $cellSize = 5;
    private $gifCellColor = [0, 0, 0];

    /**
     * Creates a png-image of the board which is saved under.
     *
     * The living cells are represented by small rectangles.
     *
     * @param Board $_board Prepares the board.
     */
    function outputBoard(Board $_board)
    {
        $cellSize = $this->cellSize;
        $gifCellColor = $this->gifCellColor;
        $board = $_board->getFieldBoard();

        $pngImage = imagecreate($_board->getHeight() * 5, $_board->getWidth() * 5);
        imagecolorallocate($pngImage, 255, 255, 255);
        $cellColor = imagecolorallocate($pngImage, intval($gifCellColor[0]), intval($gifCellColor[1]), intval($gifCellColor[2]));

        //Creates the living cells
        for ($y = 0; $y < $_board->getHeight(); ++$y)
        {
            for ($x = 0; $x < $_board->getWidth(); ++$x)
            {
                //Set color for the living cells
                if($board[$x][$y] == 1)
                    imagefilledrectangle($pngImage, $x * $cellSize, $y * $cellSize, $x * $cellSize +
                        $cellSize - 5, $y * $cellSize + $cellSize - 5, $cellColor);
            }
        }

        //Creates a new image in png-format
        imagepng($pngImage, "imageOutput/" . sprintf("gif-frame-%03d", $this->imageIndex) . ".png");
        $this->imageIndex++;
    }

    /**
     * A gif-file is automatically created by hand of the created images from the board.
     */
    function finishOutput()
    {
        $gif = new GifCreator();

        //Throws the respective error-message for an incorrect function process
        try {
            //An animated gif is automatically created and saved under the respective repository.
            $gif->create(glob("imageOutput/gif-frame-*.png"), 100, 0);
            file_put_contents("imageOutput/gif-output.gif", $gif->getGif());

            //Deletes all current images
            foreach (glob("imageOutput/gif-frame-*.png") as $filename)
            {
                unlink($filename);
            }
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
    }

    /**
     * Defines output-specific parameters, which are required when calling one of the following options ->
     * \"gifCellSize\" or \"gifCellColor\"
     *
     * @param Getopt $_options Defines output-specific parameters
     */
    function startOutput(Getopt $_options)
    {
        if ($_options->getOption("gifCellSize"))
        {
            $this->cellSize = intval($_options->getOption("gifCellSize"));

            if ($this->cellSize <= 0)
                $this->cellSize = 5;
        }

        if ($_options->getOption("gifCellColor"))
            $this->gifCellColor = explode(",", $_options->getOption("gifCellColor"));
    }


    /**
     * Adds gif-specific outputs options.
     *
     *\"gifCellSize\" set the size for each cell and needs to be defined in pixel format -> 10 for example.
     * Short option command: -p 10
     * Long option command: --gifCellSize
     *
     * \"gifCellColor\" set the color for each cell where the colors for red, green, blue needs a number -> between 0-255
     * and seperated with a comma.
     * Short command: -c 155,155,155
     * Long command: -gifCellColor 155,155,155
     *
     * @param Getopt $_options Defines output-specific options
     */
    function addOptions(Getopt $_options)
    {
        $_options->addOptions(
            [
                ['p', "gifCellSize", Getopt::REQUIRED_ARGUMENT, " Set the size for each cell inside of a gif-output in pixel-format -> CLI-command: \"-p 10\" or \"--gifCellSize 10\""],
                ['c', "gifCellColor", Getopt::REQUIRED_ARGUMENT, " Set the color for each cell inside a gif-output in rgb-format -> CLI-command: \"-c 14,155,14\" or \"--gifCellColor 14,14,14\""]
            ]
        );
    }
}
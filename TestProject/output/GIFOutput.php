<?php

namespace output;

use options\Getopt;
use cellularAutomat\Board;
use GifAnimation\GifCreator;

/**
 * An animated gif-file is automatically created by hand of the created images from the board.
 *
 * @class GifOutput
 */
class GIFOutput extends BaseOutput
{
    private $imageIndex = 0;

    /**
     * Creates a png-image of the board which is saved under.
     *
     * The living cells are represented by small rectangles.
     *
     * @param Board $_board Prepares the board.
     */
    function outputBoard(Board $_board)
    {
        $pngImage = imagecreate($_board->getHeight() * 5, $_board->getWidth() * 5);
        imagecolorallocate($pngImage, 200, 150, 100);
        $cellColor = imagecolorallocate($pngImage, 10, 10, 10);

        //Creates the living cells
        for ($y = 0; $y < $_board->getHeight(); ++$y)
        {
            for ($x = 0; $x < $_board->getWidth(); ++$x)
            {
                //Set color for the living cells
                if ($_board->setCell($x, $y, rand(0, 1)))
                    imagefilledrectangle($pngImage, $x * 5, $y * 5, $x * 5 + 5 - 5, $y * 5 + 5 - 5, $cellColor);
            }
        }

        //Creates a new image in png-format
        imagepng($pngImage, "imageOutput/" . sprintf("image-%03d", $this->imageIndex) . ".png");
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
            $gif->create(glob("imageOutput/*.png"), 50, 0);
            file_put_contents("imageOutput/animation.gif", $gif->getGif());
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
    }

}
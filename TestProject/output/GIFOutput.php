<?php

namespace output;

use options\Getopt;
use cellularAutomat\Board;
use GifAnimation\GifCreator;

/**
 * Creates an animated gif-file of the board by hand of the created images that are saved under -> TestProject/imageOutput/*.png.
 *
 * Enter following command to run \"GifOutput.php\" -> \"--output GifOutput\" or \"-o GifOutput.php\"
 *
 * @class GifOutput
 */
class GIFOutput extends BaseOutput
{
    /**
     * Creates a png-image of the board which is saved under -> TestProject/imageOutput/*.png .
     *
     * The living cells are represented by small rectangles.
     *
     * @param Board $_board
     */
    function outputBoard(Board $_board)
    {
        $pngImage = imagecreate($_board->getHeight() * 5, $_board->getWidth() * 5);
        imagecolorallocate($pngImage, 100, 100, 100);
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

        //Creates a new image which is going to be saved under -> TestProject/imageOutput/*.png
        imagepng($pngImage, "imageOutput/" . sprintf("image-%03d", $this->imageIndex) . ".png");
        $this->imageIndex++;
    }

    /**
     * Creates a gif-file that is going to be saved under -> TestProject/imageOutput/*.gif
     */
    function finishOutput()
    {
        $gif = new GifCreator();

        //Throws the respective error-message for an incorrect process function process
        try {
            //Creates a gif of the created image-files under -> TestProject/imageOutput/*.png
            $gif->create(glob("imageOutput/*.png"), 50, 0);
            //Saves the gif inside the respective directory
            file_put_contents("imageOutput/animation.gif", $gif->getGif());
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
    }

}
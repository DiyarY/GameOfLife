<?php

namespace output;

use options\Getopt;
use cellularAutomat\Board;

/**
 * Creates a png-image of the Board that are going to be saved under -> TestPorject/imageOutput/*.png
 *
 * Enter following command to run \"PNGOutput.php\" -> \"--output PNGOutput\" or \"-o PNGOutput\"
 *
 * @class PNGOutput
 */
class PNGOutput extends BaseOutput
{
    /**
     * Creates a png-image of the Board which is saved under -> TestProject/imageOutput/*.png .
     *
     * The living cells are represented by small rectangles.
     *
     * @param Board $_board
     */
      function outputBoard(Board $_board)
      {
          $pngImage = imagecreate($_board->getHeight() * 5, $_board->getWidth() * 5);
          imagecolorallocate($pngImage, 100, 100, 10);
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
}
<?php

namespace output;

use options\Getopt;
use cellularAutomat\Board;

/**
 * Creates an image of the current created board in png-format.
 *
 * @class PNGOutput
 */
class PNGOutput extends BaseOutput
{
    private $imageIndex = 0;

    /**
     * Creates an image of the current created board in png-format.
     *
     * The living cells are represented by small rectangles.
     *
     * @param Board $_board Prepares the current board.
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

          //Creates a new image in png-format
          imagepng($pngImage, "imageOutput/" . sprintf("pngImage-%03d", $this->imageIndex) . ".png");
          $this->imageIndex++;
      }
}
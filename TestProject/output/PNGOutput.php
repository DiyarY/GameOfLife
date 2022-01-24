<?php

namespace output;

use options\Getopt;
use cellularAutomat\Board;

class PNGOutput extends BaseOutput
{
      function outputBoard(Board $_board)
      {

          $pngImage = imagecreate($_board->getHeight() * 1, $_board->getWidth() * 1);
          imagecolorallocate($pngImage, 100, 100, 10);
          $cellColor = imagecolorallocate($pngImage, 10, 10, 10);

          for ($y = 0; $y < $_board->getHeight(); ++$y) {
              for ($x = 0; $x < $_board->getWidth(); ++$x) {
                  if ($_board->setCell($x, $y, rand(0, 1)))
                      imagefilledrectangle($pngImage, $x * 1, $y * 1, $x * 1 + 1 - 1, $y * 1 + 1 - 1, $cellColor);
              }
          }

          imagepng($pngImage, "imageOutput/BoardImg.png");
          //imagedestroy($pngImage);
      }
}
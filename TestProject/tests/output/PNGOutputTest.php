<?php

namespace Tests\Output;

use GameOfLife\CellularAutomat\Board;
use GameOfLife\Output\PNGOutput;
use GameOfLife\Options\Getopt;
use PHPUnit\Framework\TestCase;

/**
 * Tests whether \Output\PNGOutput works as expected.
 */
class PNGOutputTest extends TestCase
{

    protected $pngOutput;
    protected $board;
    protected $getOpt;

    protected $cellColor = ["red" => 255, "green" => 255, "blue" => 255, "alpha" => 0];
    protected $backgroundColor = ["red" => 0, "green" => 0, "blue" => 0, "alpha" => 0];

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->board = new Board(5, 5);
        $this->pngOutput = new PNGOutput();
        $this->getOpt = $this->createMock(Getopt::class);

        $this->currentDir = getcwd();
        chdir("/tmp");
        if (!is_dir("/tmp/imageOutput")) mkdir("/tmp/imageOutput");
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unlink("imageOutput/pngImage-000.png");
        unlink("imageOutput/referenceImage.png");
        rmdir("imageOutput/");
        chdir($this->currentDir);
    }

    /**
     * Asserts that the two png-images of the board aren't empty, by setting a background- and cell-color for each board.
     *
     * @test
     */
    public function boardsAreNotEmpty()
    {
        $this->pngOutput->startOutput($this->getOpt);
        $this->pngOutput->outputBoard($this->board);
        $this->pngOutput->finishOutput();

        $pngImage = imagecreate(5, 5);
        imagecolorallocate($pngImage, 0, 0, 0);
        imagecolorallocate($pngImage, 100, 100, 100);
        imagepng($pngImage, "imageOutput/referenceImage.png");

        $currentPngImage = file_get_contents("imageOutput/pngImage-000.png");
        $testPngImage = file_get_contents("imageOutput/referenceImage.png");

        $this->assertNotEmpty($currentPngImage, $testPngImage);
    }

    /**
     * Checks whether the coordinated cell is set on true.
     *
     * @test
     */
    public function checkWhetherCellsAreSetOnTrue()
    {
        $this->board = new Board(5,5);
        $this->board->setCell(0,0,1);

        $this->pngOutput->startOutput($this->getOpt);
        $this->pngOutput->outputBoard($this->board);

        $pngImage = imagecreate(5, 5);
        imagecolorallocate($pngImage, 0, 0, 0);
        imagecolorallocate($pngImage, 100, 100, 100);
        imagepng($pngImage, "imageOutput/referenceImage.png");

        $pngImage = imagecreatefrompng("imageOutput/pngImage-000.png");

        $this->assertFalse($this->cellSetOnTrue($this->board, $pngImage, $this->cellColor, $this->backgroundColor));
    }

    /**
     * Sets the background- and cell-color of the current board.
     *
     * @param Board $_board
     * @param $_pngOutput
     * @param $_cellColor
     * @param $_backgroundColor
     * @return bool
     */
    private function cellSetOnTrue(Board $_board, $_pngOutput, $_cellColor, $_backgroundColor )
    {
        $this->cellColor = $_cellColor;
        $this->backgroundColor = $_backgroundColor;

        $isEqual = true;
        for ($y = 0; $y < $_board->getHeight(); $y++)
        {
            for ($x = 0; $x < $_board->getWidth(); $x++)
            {
                $backgroundColor = imagecolorat($_pngOutput, $x, $y);
                $cellColor = imagecolorsforindex($_pngOutput, $backgroundColor);

                if ($_board->getBoard())
                    if ($cellColor != $_cellColor) $isEqual = false;
                    elseif ($cellColor != $_backgroundColor) $isEqual = false;
            }
        }
        return $isEqual;
    }
}
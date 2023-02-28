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
     */
    public function testChecksIfBoardsAreTheSameAndNotEmpty()
    {
        $this->pngOutput->startOutput($this->getOpt);
        $this->pngOutput->outputBoard($this->board);
        $this->pngOutput->finishOutput();

        $pngImage = imagecreate(5, 5);
        imagecolorallocate($pngImage, 0, 0, 0);
        imagecolorallocate($pngImage, 255, 255, 255);
        imagepng($pngImage, "imageOutput/referenceImage.png");

        $referenceImage = file_get_contents("imageOutput/referenceImage.png");

        $this->assertEquals($referenceImage, file_get_contents("imageOutput/pngImage-000.png"));
    }

    /**
     * Tests whether the board is not empty.
     *
     * @return void
     */
    public function testNonEmptyBoard()
    {
        $this->pngOutput->startOutput($this->getOpt);
        $this->board->setCell(0,0,1);
        $this->pngOutput->outputBoard($this->board);
        $this->pngOutput->finishOutput();

        $pngImage = imagecreate(5,5);
        imagecolorallocate($pngImage, 0,0,0);
        $template = imagecolorallocate($pngImage, 255,255,255);
        imagesetpixel($pngImage,0,0,$template);
        imagepng($pngImage, "imageOutput/referenceImage.png");

        $this->assertNotEmpty(file_get_contents("imageOutput/pngImage-000.png"), file_get_contents("imageOutput/referenceImage.png"));
    }
}
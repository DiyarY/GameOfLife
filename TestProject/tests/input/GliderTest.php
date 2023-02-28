<?php

namespace Tests\Input;

use GameOfLife\CellularAutomat\Board;
use GameOfLife\Options\Getopt;
use GameOfLife\Input\Glider;
use PHPUnit\Framework\TestCase;

/**
 * Tests whether \Input\Glider works as expected.
 */
class GliderTest extends TestCase
{
    /**
     * @var Glider $glider Represents the glider.
     * @var Getopt|(Getopt&\PHPUnit\Framework\MockObject\MockObject)|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $glider;
    protected $getOption;

    /**
     * Initialization of the Glider class.
     *
     * \options\Getopt will be mocked.
     *
     * @return void
     */
    protected function setUp(): void
    {
        $this->glider = new Glider();
        $this->getOption = $this->createMock(Getopt::class);
    }

    /**
     * Asserts that two arrays of the same size and living cells, which represents the coordinates for the glider, are equal.
     */
    public function testGliderFill1()
    {
        $board = new Board(5, 5);

        $gliderArray = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 0],
            [0, 0, 0, 0, 1],
            [0, 0, 1, 0, 1],
            [0, 0, 0, 1, 1]
        ];

        $this->glider->fillBoard($board, $this->getOption);

        $this->assertEquals($gliderArray, $board->getFieldBoard());
    }

    /**
     * Asserts that two arrays of the same size and living cells, which represents the coordinates for the glider, are equal.
     */
    public function testGliderFill2()
    {
        $board = new Board(3,3);

        $gliderArray = [
            [0, 0, 0],
            [0, 0, 0],
            [0, 1, 0]
        ];

        $this->glider->fillBoard($board, $this->getOption);

        $this->assertEquals($gliderArray, $board->getFieldBoard());
    }

    /**
     * Asserts that two arrays of the same size and living cells, which represents the coordinates for the glider, are equals.
     *
     * The startpoint for the glider, which are two integers defined as string, seperated by a comma, represents the coordinates
     * for the x- and y-axis -> example: "1,1"
     */
    public function testGliderFillWithPosition()
    {
        $this->getOption->method("getOption")
            ->with("gliderPosition")
            ->willReturn("1,1");

        $board = new Board(5, 5);

        $gliderArray = [
            [0, 0, 0, 0, 0],
            [0, 0, 0, 1, 0],
            [0, 1, 0, 1, 0],
            [0, 0, 1, 1, 0],
            [0, 0, 0, 0, 0]
        ];

        $this->glider->fillBoard($board, $this->getOption);

        $this->assertEquals($gliderArray, $board->getFieldBoard());
    }

    /**
     * Tests whether the extended-option is being called.
     *
     * @return void
     */
    public function testIfAddOptionTakesAnOption()
    {
        $this->glider->addOptions($this->getOption);
        $this->assertNotEmpty($this->glider);
    }
}
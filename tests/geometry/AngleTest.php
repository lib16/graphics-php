<?php
namespace Lib16\Graphics\Tests\Geometry;

use Lib16\Graphics\Geometry\Angle;
use PHPUnit\Framework\TestCase;

class AngleTest extends TestCase
{
    public function testCopy()
    {
        $angle1 = new Angle(\pi());
        $angle2 = $angle1->copy();
        $this->assertEquals(180, $angle2->getDegrees());
    }

    public function testAddDegrees()
    {
        $angle = Angle::byDegrees(90)->addDegrees(120);
        $this->assertEquals(210, $angle->getDegrees());
    }

    public function testSetDegrees()
    {
        $angle = Angle::byDegrees(90)->setDegrees(120);
        $this->assertEquals(120, $angle->getDegrees());
    }
}
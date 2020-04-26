<?php
namespace Lib16\Graphics\Tests\Geometry\PathCommands;

use Lib16\Utils\NumberFormatter;
use Lib16\Graphics\Geometry\ {
    Angle,
    Point,
    Command
};
use Lib16\Graphics\Geometry\PathCommands\ {
    Arc,
    ClosePath,
    CubicCurveTo,
    HorizontalLineTo,
    LineTo,
    MoveTo,
    QuadraticCurveTo,
    SmoothCubicCurveTo,
    SmoothQuadraticCurveTo,
    VerticalLineTo
};
use PHPUnit\Framework\TestCase;

class CommandsTest extends TestCase
{
    static $p1, $p2, $p3, $a;

    public function setUp()
    {
        self::$p1 = new Point(10, 20);
        self::$p2 = new Point(30, 40);
        self::$p3 = new Point(50, 60);
        self::$a = Angle::byDegrees(45);
    }

    public function testMoveTo()
    {
        $this->assertEqualSvg(
            "M 1.2346,78.9",
            new MoveTo(new Point(1.23456, 78.9))
        );
    }

    public function testLineTo()
    {
        $this->assertEqualSvg(
            "L 1.2346,78.9",
            new LineTo(new Point(1.23456, 78.9))
        );
    }

    public function testHorizontalLineTo()
    {
        $this->assertEqualSvg("H 100", new HorizontalLineTo(100));
    }

    public function testVerticalLineTo()
    {
        $this->assertEqualSvg("V 100", new VerticalLineTo(100));
    }

    public function testCubicCurveTo()
    {
        $this->assertEqualSvg(
            "C 10,20 30,40 50,60",
            new CubicCurveTo(self::$p1, self::$p2, self::$p3)
        );
    }

    public function testSmoothCubicCurveTo()
    {
        $this->assertEqualSvg(
            "S 10,20 30,40",
            new SmoothCubicCurveTo(self::$p1, self::$p2)
        );
    }

    public function testQuadraticCurveTo()
    {
        $this->assertEqualSvg(
            "Q 10,20 30,40",
            new QuadraticCurveTo(self::$p1, self::$p2)
        );
    }

    public function testSmoothQuadraticCurveTo()
    {
        $this->assertEqualSvg(
            "T 10,20",
            new SmoothQuadraticCurveTo(self::$p1)
        );
    }

    public function testArc1()
    {
        $this->assertEqualSvg(
            "A 10 20 45 1 0 10,20",
            new Arc(10, 20, self::$a, true, false, self::$p1)
        );
    }

    public function testArc2()
    {
        $this->assertEqualSvg(
            "A 10 20 0 0 1 10,20",
            new Arc(10, 20, null, false, true, self::$p1)
        );
    }

    public function testClosePath()
    {
        $this->assertEqualSvg('Z', new ClosePath());
    }

    public function assertEqualSvg(string $expected, Command $command)
    {
        $f = new NumberFormatter(4);
        $this->assertEquals($expected, $command->toSvg($f, $f));
        $this->assertEquals(\strtolower($expected), $command->rel()->toSvg($f, $f));
    }
}

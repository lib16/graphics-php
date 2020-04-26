<?php
namespace Lib16\Graphics\Geometry;

use Lib16\Utils\NumberFormatter;
use PHPUnit\Framework\TestCase;

function path(): BezierPath
{
    return new BezierPath();
}

function p(float $x, float $y)
{
    return new Point($x, $y);
}

class BezierPathTest extends TestCase
{
    private static $f, $a45, $c, $s2, $cp1, $cp2;

    public function setUp()
    {
        self::$f = new NumberFormatter(4);
        self::$a45 = Angle::byDegrees(45);
        self::$c = p(0, 0);
        self::$s2 = self::$f->format(10 * sqrt(2));
        self::$cp1 = self::$f->format(10 * BezierPath::QUADRANT_FACTOR);
        self::$cp2 = self::$f->format(40 + 10 * BezierPath::QUADRANT_FACTOR);
    }

    public function testRectangle1()
    {
        $this->assertEqualSvg(
            'M 10,20 L 110,20 L 110,100 L 10,100 Z',
            path()->rectangle(p(10, 20), 100, 80)
        );
    }

    public function testRectangle2()
    {
        $this->assertEqualSvg(
            'M 10,100 L 110,100 L 110,20 L 10,20 Z',
            path()->ccw()->rectangle(p(10, 20), 100, 80)
        );
    }

    public function testRoundedRectangle1()
    {
        $this->assertEqualSvg(
            'M 40,-50'
            . ' C ' . self::$cp2 . ',-50 50,-' . self::$cp2 . ' 50,-40'
            . ' L 50,40'
            . ' C 50,' . self::$cp2 . ' ' . self::$cp2 . ',50 40,50'
            . ' L -40,50'
            . ' C -' . self::$cp2 . ',50 -50,' . self::$cp2 . ' -50,40'
            . ' L -50,-40'
            . ' C -50,-' . self::$cp2 . ' -' . self::$cp2 . ',-50 -40,-50'
            . ' Z',
            path()->roundedRectangle(p(-50, -50), 100, 100, 10)
        );
    }

    public function testRoundedRectangle2()
    {
        $this->assertEqualSvg(
            'M -40,-50'
            . ' C -' . self::$cp2 . ',-50 -50,-' . self::$cp2 . ' -50,-40'
            . ' L -50,40'
            . ' C -50,' . self::$cp2 . ' -' . self::$cp2 . ',50 -40,50'
            . ' L 40,50'
            . ' C ' . self::$cp2 . ',50 50,' . self::$cp2 . ' 50,40'
            . ' L 50,-40'
            . ' C 50,-' . self::$cp2 . ' ' . self::$cp2 . ',-50 40,-50'
            . ' Z',
            path()->ccw()->roundedRectangle(p(-50, -50), 100, 100, 10)
        );
    }

    public function testEllipse1()
    {
        $this->assertEqualSvg(
            'M 0,-10'
            . ' C ' . self::$cp1 . ',-10 10,-' . self::$cp1 . ' 10,0'
            . ' C 10,' . self::$cp1 . ' ' . self::$cp1 . ',10 0,10'
            . ' C -' . self::$cp1 . ',10 -10,' . self::$cp1 . ' -10,0'
            . ' C -10,-' . self::$cp1 . ' -' . self::$cp1 . ',-10 0,-10',
            path()->ellipse(p(0, 0), 10, 10)
        );
    }

    public function testEllipse2()
    {
        $this->assertEqualSvg(
            'M 0,-10'
            . ' C -' . self::$cp1 . ',-10 -10,-' . self::$cp1 . ' -10,0'
            . ' C -10,' . self::$cp1 . ' -' . self::$cp1 . ',10 0,10'
            . ' C ' . self::$cp1 . ',10 10,' . self::$cp1 . ' 10,0'
            . ' C 10,-' . self::$cp1 . ' ' . self::$cp1 . ',-10 0,-10',
            path()->ccw()->ellipse(p(0, 0), 10, 10)
        );
    }

    public function testCircle1()
    {
        $this->assertEqualSvg(
            'M 0,-10'
            . ' C ' . self::$cp1 . ',-10 10,-' . self::$cp1 . ' 10,0'
            . ' C 10,' . self::$cp1 . ' ' . self::$cp1 . ',10 0,10'
            . ' C -' . self::$cp1 . ',10 -10,' . self::$cp1 . ' -10,0'
            . ' C -10,-' . self::$cp1 . ' -' . self::$cp1 . ',-10 0,-10',
            path()->circle(p(0, 0), 10)
        );
    }

    public function testCircle2()
    {
        $this->assertEqualSvg(
            'M 0,-10'
            . ' C -' . self::$cp1 . ',-10 -10,-' . self::$cp1 . ' -10,0'
            . ' C -10,' . self::$cp1 . ' -' . self::$cp1 . ',10 0,10'
            . ' C ' . self::$cp1 . ',10 10,' . self::$cp1 . ' 10,0'
            . ' C 10,-' . self::$cp1 . ' ' . self::$cp1 . ',-10 0,-10',
            path()->ccw()->circle(p(0, 0), 10)
        );
    }

    public function testStar1()
    {
        $this->assertEqualSvg(
            'M 10,-80 L 110,20 L 10,120 L -90,20 Z',
            path()->star(p(10, 20), 4, 100)
        );
    }

    public function testStar2()
    {
        $this->assertEqualSvg(
            'M 10,-80 L -90,20 L 10,120 L 110,20 Z',
            path()->ccw()->star(p(10, 20), 4, 100)
        );
    }

    public function testStar3()
    {
        $this->assertEqualSvg(
            'M 10,-80 L 110,20 L 10,120 L -90,20 Z',
            path()->star(p(10, 20), 4, 100)
        );
    }

    public function testStar4()
    {
        $this->assertEqualSvg(
            'M 10,-80 L 60,20 L 10,120 L -40,20 Z',
            path()->star(p(10, 20), 2, 100, 50)
        );
    }

    public function testStar5()
    {
        $this->assertEqualSvg(
            'M 10,-80 L -40,20 L 10,120 L 60,20 Z',
            path()->ccw()->star(p(10, 20), 2, 100, 50)
        );
    }

    public function testStar6()
    {
        $this->assertEqualSvg(
            'M 10,-80 L 60,20 L 10,120 L -40,20 Z',
            path()->star(p(10, 20), 1, 100, 50, 100, 50)
        );
    }

    public function testStar7()
    {
        $this->assertEqualSvg(
            'M 10,-80 L -40,20 L 10,120 L 60,20 Z',
            path()->ccw()->star(p(10, 20), 1, 100, 50, 100, 50)
        );
    }

    public function testTransformations1()
    {
        $this->assertEqualSvg(
            'M 0,-' .
            self::$s2 . ' L ' . self::$s2 . ',0 L 0,' .
            self::$s2 . ' L -' . self::$s2 . ',0 Z',
            path()->rectangle(p(-10, -10), 20, 20)->rotate(self::$c, self::$a45)
        );
    }

    public function testTransformations2()
    {
        $this->assertEqualSvg(
            'M -20,-20 L 20,-20 L 20,20 L -20,20 Z',
            path()->rectangle(p(-10, -10), 20, 20)->scale(self::$c, 2)
        );
    }

    public function testTransformations3()
    {
        $this->assertEqualSvg(
            'M 10,-10 L -10,-10 L -10,10 L 10,10 Z',
            path()->rectangle(p(-10, -10), 20, 20)->scaleX(self::$c, -1)
        );
    }

    public function testTransformations4()
    {
        $this->assertEqualSvg(
            'M -10,10 L 10,10 L 10,-10 L -10,-10 Z',
            path()->rectangle(p(-10, -10), 20, 20)->scaleY(self::$c, -1)
        );
    }

    public function testTransformations5()
    {
        $this->assertEqualSvg(
            'M -20,-10 L 0,-10 L 20,10 L 0,10 Z',
            path()->rectangle(p(-10, -10), 20, 20)->skewX(self::$c, self::$a45)
        );
    }

    public function testTransformations6()
    {
        $this->assertEqualSvg(
            'M -10,-20 L 10,0 L 10,20 L -10,0 Z',
            path()->rectangle(p(-10, -10), 20, 20)->skewY(self::$c, self::$a45)
        );
    }

    public function testTransformations7()
    {
        $this->assertEqualSvg(
            'M -5,5 L 15,5 L 15,25 L -5,25 Z',
            path()->rectangle(p(-10, -10), 20, 20)->translate(5, 15)
        );
    }

    public function testTransformations8()
    {
        $this->assertEqualSvg(
            'M -5,-10 L 15,-10 L 15,10 L -5,10 Z',
            path()->rectangle(p(-10, -10), 20, 20)->translateX(5)
        );
    }

    public function testTransformations9()
    {
        $this->assertEqualSvg(
            'M -10,5 L 10,5 L 10,25 L -10,25 Z',
            path()->rectangle(p(-10, -10), 20, 20)->translateY(15)
        );
    }

    public function assertEqualSvg(string $expected, BezierPath $path)
    {
        $this->assertEquals($expected, $path->toSvg(self::$f, self::$f));
    }
}

<?php
namespace Lib16\Graphics\Tests\Geometry;

use Lib16\Graphics\Geometry\Angle;
use Lib16\Graphics\Geometry\Point;
use PHPUnit\Framework\TestCase;
use Lib16\Graphics\Geometry\PointSet;

class PointTest extends TestCase
{
    public function testCopy()
    {
        $point1 = new Point(10, 15.5);
        $point2 = $point1->copy();
        $this->assertEqualCoordinates(10, 15.5, $point2);
    }

    /**
     * @dataProvider rotateProvider
     */
    public function testRotate(
        $x,
        $y,
        $cx,
        $cy,
        $degrees,
        $expectedX,
        $expectedY
    ) {
        $this->assertEqualCoordinates(
            $expectedX,
            $expectedY,
            (new Point($x, $y))->rotate(
                new Point($cx, $cy),
                Angle::byDegrees($degrees)
            )
        );
    }

    public function rotateProvider()
    {
        $degrees = 60;
        $angle = Angle::byDegrees($degrees);
        $sin = $angle->getSin();
        $cos = $angle->getCos();
        return [
            [1, 0, 0, 0, $degrees, $cos, $sin],
            [0, 1, 0, 0, $degrees, -$sin, $cos],
            [-1, 0, 0, 0, $degrees, -$cos, -$sin],
            [0, -1, 0, 0, $degrees, $sin, -$cos],
            [2, 1, 1, 1, $degrees, 1 + $cos, 1 + $sin],
            [1, 2, 1, 1, $degrees, 1 - $sin, 1 + $cos],
            [0, 1, 1, 1, $degrees, 1 - $cos, 1 - $sin],
            [1, 0, 1, 1, $degrees, 1 + $sin, 1 - $cos],
        ];
    }

    /**
     * @dataProvider scaleProvider
     */
    public function testScale($x, $y, $cx, $cy, $factor, $expectedX, $expectedY)
    {
        $this->assertEqualCoordinates(
            $expectedX,
            $expectedY,
            (new Point($x, $y))->scale(new Point($cx, $cy), $factor)
        );
    }

    public function scaleProvider()
    {
        return [
            [100, 200, 0, 0, 0.5, 50, 100],
            [100, 200, 50, 50, 0.5, 75, 125],
        ];
    }

    /**
     * @dataProvider skewXProvider
     */
    public function testSkewX(
        $x,
        $y,
        $cx,
        $cy,
        $degrees,
        $expectedX,
        $expectedY
    ) {
        $this->assertEqualCoordinates(
            $expectedX,
            $expectedY,
            (new Point($x, $y))->skewX(
                new Point($cx, $cy),
                Angle::byDegrees($degrees)
            )
        );
    }

    public function skewXProvider()
    {
        return [
            [0,10, 0,0, 45, 10,10],
            [10,10, 0,0, 45, 20,10],
            [0,-10, 0,0, 45, -10,-10],
            [0,10, 40,40, 45, -30,10],
            [10,10, 40,40, 45, -20,10],
            [0,-10, 40,40, 45, -50,-10]
        ];
    }

    /**
     * @dataProvider skewYProvider
     */
    public function testSkewY(
        $x,
        $y,
        $cx,
        $cy,
        $degrees,
        $expectedX,
        $expectedY
    ) {
        $this->assertEqualCoordinates(
            $expectedX,
            $expectedY,
            (new Point($x, $y))->skewY(
                new Point($cx, $cy),
                Angle::byDegrees($degrees)
            )
        );
    }

    public function skewYProvider()
    {
        return [
            [10,0, 0,0, 45, 10,10],
            [10,10, 0,0, 45, 10,20],
            [-10,0, 0,0, 45, -10,-10],
            [10,0, 40,40, 45, 10,-30],
            [10,10, 40,40, 45, 10,-20],
            [-10,0, 40,40, 45, -10,-50]
        ];
    }

    public function testTranslate()
    {
        $this->assertEqualCoordinates(
            25,
            25,
            (new Point(20.5, 10))->translate(4.5, 15)
        );
    }

    public function testIterator()
    {
        $points = [p(0,0), p(1,0), p(2,0), p(0,1)];
        $pointSet = new PointSet(...$points);
        foreach ($pointSet as $i => $point) {
            $this->assertEquals($points[$i], $point);
        }
    }

    public function assertEqualCoordinates($expectedX, $expectedY, Point $point)
    {
        $this->assertEquals([$expectedX, $expectedY], [$point->x, $point->y]);
    }
}

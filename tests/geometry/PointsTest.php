<?php
namespace Lib16\Graphics\Tests\Geometry;

use Lib16\Graphics\Geometry\ {
    Angle,
    Point,
    Points
};
use PHPUnit\Framework\TestCase;

class PointsTest extends TestCase
{
    static $p1, $a1, $a2, $l1, $l2;

    public function setUp()
    {
        self::$p1 = new Point(10, 20);
        self::$a1 = Angle::byDegrees(45);
        self::$a2 = Angle::byDegrees(135);
        self::$l1 = sin(deg2rad(45)) * 100;
        self::$l2 = self::$l1 / 2;
    }

    public function testRectangle()
    {
        $this->assertEqualPoints(
            [[10, 20], [110, 20], [110, 100], [10, 100]],
            Points::rectangle(self::$p1, 100, 80)
        );
    }

    public function testRoundedRectangle()
    {
        $this->assertEqualPoints(
            [
                [100, 20], [110, 30], [110, 90], [100, 100],
                [20, 100], [10, 90], [10, 30], [20, 20]
            ],
            Points::roundedRectangle(self::$p1, 100, 80, 10)
        );
    }

    public function testStar1()
    {
        $this->assertEqualPoints(
            [[10, -80], [110, 20], [10, 120], [-90, 20]],
            Points::star(self::$p1, 4, 100)
        );
    }

    public function testStar2()
    {
        $this->assertEqualPoints(
            [[10, -80], [60, 20], [10, 120], [-40, 20]],
            Points::star(self::$p1, 1, 100, 50, 100, 50)
        );
    }

    public function testInnerRadiusStar()
    {
        $this->assertEquals(
            Points::STAR_RADIUS_5_2,
            Points::innerRadiusStar(5, 2),
            0.01
        );
    }

    public function testSector()
    {
        $this->assertEqualPoints(
            [[10, 20], [10+self::$l1, 20+self::$l1], [10-self::$l1, 20+self::$l1]],
            Points::sector(self::$p1, self::$a1, self::$a2, 100)
        );
    }

    public function testRingSector()
    {
        $this->assertEqualPoints(
            [
                [10+self::$l1, 20+self::$l1],
                [10-self::$l1, 20+self::$l1],
                [10-self::$l2, 20+self::$l2],
                [10+self::$l2, 20+self::$l2]
            ],
            Points::ringSector(self::$p1, self::$a1, self::$a2, 100, 50)
        );
    }

    public function testCross()
    {
        $this->assertEqualPoints(
            [[10, -10], [50, 20], [10, 50], [-30, 20]],
            Points::cross(self::$p1, 40, 30)
        );
    }

    public function testTranslateXY()
    {
        // for coverage
        $expected = Points::rectangle(p(10, -10), 10, 10);
        $actual = $expected;
        Points::translateX(3, $expected);
        Points::translateY(2, $expected);
        Points::translate(3, 2, $actual);
        $this->assertEquals($expected, $actual);
    }

    public function assertEqualPoints(array $expected, array $actual)
    {
        for ($i = 0; $i < count($expected); $i++) {
            $this->assertEquals($expected[$i][0], $actual[$i]->x, 0.01);
            $this->assertEquals($expected[$i][1], $actual[$i]->y, 0.01);
        }
    }
}
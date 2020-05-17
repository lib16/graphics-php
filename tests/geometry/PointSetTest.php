<?php
namespace Lib16\Graphics\Tests\Geometry;

use Lib16\Graphics\Geometry\PointSet;
use Lib16\Graphics\Geometry\VectorGraphics as G;
use PHPUnit\Framework\TestCase;

class PointSetTest extends TestCase
{
    static $p1, $a1, $a2, $l1, $l2;

    public function setUp()
    {
        self::$p1 = G::p(10, 20);
        self::$a1 = G::deg(45);
        self::$a2 = G::deg(135);
        self::$l1 = sin(deg2rad(45)) * 100;
        self::$l2 = self::$l1 / 2;
    }

    public function testRectangle1()
    {
        $this->assertEqualPointSet(
            [[10, 20], [110, 20], [110, 100], [10, 100]],
            G::rectangle(self::$p1, 100, 80)
        );
    }

    public function testRectangle2()
    {
        $this->assertEqualPointSet(
            [[110, 20], [10, 20], [10, 100], [110, 100]],
            G::rectangle(self::$p1, 100, 80, true)
        );
    }

    public function testStar1()
    {
        $this->assertEqualPointSet(
            [[10, -80], [110, 20], [10, 120], [-90, 20]],
            G::star(self::$p1, 4, 100)
        );
    }

    public function testStar2()
    {
        $this->assertEqualPointSet(
            [[10, -80], [60, 20], [10, 120], [-40, 20]],
            G::star(self::$p1, 1, 100, 50, 100, 50)
        );
    }

    public function testInnerRadiusStar()
    {
        $this->assertEquals(
            G::STAR_RADIUS_5_2,
            G::innerRadiusStar(5, 2),
            0.01
        );
    }

    public function testTranslateXY()
    {
        // for coverage
        $expected = G::rectangle(p(10, -10), 10, 10);
        $actual = $expected;
        $expected->translateX(3)->translateY(2);
        $actual->translate(3, 2);
        $this->assertEquals($expected, $actual);
    }

    public function testSetPoint()
    {
        $this->assertEqualPointSet(
            [[10, 20], [90, 20], [110, 100], [10, 100]],
            G::rectangle(self::$p1, 100, 80)->setPoint(1, G::p(90, 20))
        );
    }

    public function assertEqualPointSet(array $expected, PointSet $actual)
    {
        $array = [];
        for ($i = 0; $i < $actual->count(); $i++) {
            $array[] = [$actual->getPoint($i)->x, $actual->getPoint($i)->y];
        }
        $this->assertEquals($expected, $array);
    }
}
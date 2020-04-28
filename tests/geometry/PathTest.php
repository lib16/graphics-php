<?php
namespace Lib16\Graphics\Tests\Geometry;

use Lib16\Utils\NumberFormatter;
use Lib16\Graphics\Geometry\ {
    Angle,
    Path,
    Point
};
use Lib16\Graphics\Geometry\VectorGraphics as G;
use PHPUnit\Framework\TestCase;

function p(float $x = 0, float $y = 0): Point
{
    return G::point($x, $y);
}

function a(float $degrees): Angle
{
    return G::deg($degrees);
}

class PathTest extends TestCase
{
    static $f, $a, $pR1, $pR2;

    public function setUp()
    {
        self::$f = new NumberFormatter(4);
        self::$a = [];
        self::$pR1 = [];
        self::$pR2 = [];
        $i = 0;
        foreach ([30, 60, 215] as $degrees) {
            self::$a[$i] = a($degrees);
            self::$pR1[$i] = (p(
                self::$a[$i]->getCos() * 50 + 10,
                self::$a[$i]->getSin() * 50 + 20
            ))->toSvg(self::$f);
            self::$pR2[$i] = (p(
                self::$a[$i]->getCos() * 25 + 10,
                self::$a[$i]->getSin() * 25 + 20
            ))->toSvg(self::$f);
            $i++;
        }
    }

    public function testRectangle1()
    {
        $this->assertEqualSvg(
            'M 10,20 H 110 V 100 H 10 Z',
            G::path()->rectangle(p(10, 20), 100, 80)
        );
    }

    public function testRectangle2()
    {
        $this->assertEqualSvg(
            'M 10,100 H 110 V 20 H 10 Z',
            G::path()->ccw()->rectangle(p(10, 20), 100, 80)
        );
    }

    public function testRoundedRectangle1()
    {
        $this->assertEqualSvg(
            'M 100,20 A 10 10 0 0 1 110,30 ' .
            'V 90 A 10 10 0 0 1 100,100 ' .
            'H 20 A 10 10 0 0 1 10,90 ' .
            'V 30 A 10 10 0 0 1 20,20 Z',
            G::path()->cw()->roundedRectangle(p(10, 20), 100, 80, 10)
        );
    }

    public function testRoundedRectangle2()
    {
        $this->assertEqualSvg(
            'M 20,20 A 10 10 0 0 0 10,30 ' .
            'V 90 A 10 10 0 0 0 20,100 ' .
            'H 100 A 10 10 0 0 0 110,90 ' .
            'V 30 A 10 10 0 0 0 100,20 Z',
            G::path()->ccw()->roundedRectangle(p(10, 20), 100, 80, 10)
        );
    }

    public function testCircle1()
    {
        $this->assertEqualSvg(
            'M 110,20 A 100 100 0 0 1 -90,20 A 100 100 0 0 1 110,20',
            G::path()->circle(p(10, 20), 100)
        );
    }

    public function testCircle2()
    {
        $this->assertEqualSvg(
            'M 110,20 A 100 100 0 0 0 -90,20 A 100 100 0 0 0 110,20',
            G::path()->ccw()->circle(p(10, 20), 100)
        );
    }

    public function testEllipse1()
    {
        $this->assertEqualSvg(
            'M 110,20 A 100 50 0 0 1 -90,20 A 100 50 0 0 1 110,20',
            G::path()->ellipse(p(10, 20), 100, 50)
        );
    }

    public function testEllipse2()
    {
        $this->assertEqualSvg(
            'M 10,120 A 100 50 90 0 0 10,-80 A 100 50 90 0 0 10,120',
            G::path()->ccw()->ellipse(p(10, 20), 100, 50, a(90))
        );
    }

    public function testStar1()
    {
        $this->assertEqualSvg(
            'M 10,-80 L 110,20 L 10,120 L -90,20 Z',
            G::path()->star(p(10, 20), 4, 100)
        );
    }

    public function testStar2()
    {
        $this->assertEqualSvg(
            'M 10,-80 L -90,20 L 10,120 L 110,20 Z',
            G::path()->ccw()->star(p(10, 20), 4, 100)
        );
    }

    public function testStar3()
    {
        $this->assertEqualSvg(
            'M 10,-80 L 60,20 L 10,120 L -40,20 Z',
            G::path()->star(p(10, 20), 2, 100, 50)
        );
    }

    public function testStar4()
    {
        $this->assertEqualSvg(
            'M 10,-80 L -40,20 L 10,120 L 60,20 Z',
            G::path()->ccw()->star(p(10, 20), 2, 100, 50)
        );
    }

    public function testStar5()
    {
        $this->assertEqualSvg(
            'M 10,-80 L 60,20 L 10,120 L -40,20 Z',
            G::path()->star(p(10, 20), 1, 100, 50, 100, 50)
        );
    }

    public function testStar6()
    {
        $this->assertEqualSvg(
            'M 10,-80 L -40,20 L 10,120 L 60,20 Z',
            G::path()->ccw()->star(p(10, 20), 1, 100, 50, 100, 50)
        );
    }

    public function testSector1()
    {
        $this->assertEqualSvg(
            'M 10,20 L ' . self::$pR1[0] . ' A 50 50 0 0 1 ' . self::$pR1[1] . ' Z',
            G::path()->sector(p(10, 20), self::$a[0], self::$a[1], 50)
        );
    }

    public function testSector2()
    {
        $this->assertEqualSvg(
            'M 10,20 L ' . self::$pR1[0] . ' A 50 50 0 1 1 ' . self::$pR1[2] . ' Z',
            G::path()->sector(p(10, 20), self::$a[0], self::$a[2], 50)
        );
    }

    public function testSector3()
    {
        $this->assertEqualSvg(
            'M 10,20 L ' . self::$pR1[1] . ' A 50 50 0 0 0 ' . self::$pR1[0] . ' Z',
            G::path()->ccw()->sector(p(10, 20), self::$a[0], self::$a[1], 50)
        );
    }

    public function testRingSector1()
    {
        $this->assertEqualSvg(
            'M ' . self::$pR1[0] . ' A 50 50 0 0 1 ' . self::$pR1[1] . ' ' .
            'L ' . self::$pR2[1] . ' A 25 25 0 0 0 ' . self::$pR2[0] . ' Z',
            G::path()->ringSector(p(10, 20), self::$a[0], self::$a[1], 50, 25)
        );
    }

    public function testRingSector2()
    {
        $this->assertEqualSvg(
            'M ' . self::$pR1[0] . ' A 50 50 0 1 1 ' . self::$pR1[2] . ' ' .
            'L ' . self::$pR2[2] . ' A 25 25 0 1 0 ' . self::$pR2[0] . ' Z',
            G::path()->ringSector(p(10, 20), self::$a[0], self::$a[2], 50, 25)
        );
    }

    public function testRingSector3()
    {
        $this->assertEqualSvg(
            'M ' . self::$pR1[1] . ' A 50 50 0 0 0 ' . self::$pR1[0] . ' ' .
            'L ' . self::$pR2[0] . ' A 25 25 0 0 1 ' . self::$pR2[1] . ' Z',
            G::path()->ccw()->ringSector(p(10, 20), self::$a[0], self::$a[1], 50, 25)
        );
    }

    public function assertEqualSvg(string $expected, Path $path)
    {
        $this->assertEquals($expected, $path->toSvg(self::$f, self::$f));
    }

    public function testGetCommands()
    {
        $command = G::path()->rectangle(G::p(0, 0), 10, 10)->getCommands()[0];
        $this->assertEquals(false, $command->isRelative());
    }
}
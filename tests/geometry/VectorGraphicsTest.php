<?php
namespace Lib16\Graphics\Tests\Geometry;

use Lib16\Graphics\Geometry\ {
    Angle,
    Path,
    Point,
    PointSet
};
use Lib16\Graphics\Geometry\VectorGraphics as G;
use PHPUnit\Framework\TestCase;
use Lib16\Utils\NumberFormatter;

class VectorGraphicsTest extends TestCase
{
    public function test()
    {
        $this->assertEquals(Angle::byDegrees(30), G::angle(30));
        $this->assertEquals(Angle::byDegrees(30), G::deg(30));
        $this->assertEquals(new Angle(0.2), G::rad(0.2));
        $this->assertEquals(new Point(0.1, 0.2), G::p(0.1, 0.2));
        $this->assertEquals(new Path(), G::path());

        $p = G::p(1.25, 2.5);
        $a = G::deg(30);
        $f = New NumberFormatter(4);
        $this->assertEquals(
            PointSet::rectangle($p, 10, 5)->toSvg($f),
            G::rectangle($p, 10, 5)->toSvg($f)
        );
        $this->assertEquals(
            PointSet::star($p, 5, 6, 6*PointSet::STAR_RADIUS_5_2)->toSvg($f),
            G::star($p, 5, 6, 6*G::STAR_RADIUS_5_2)->toSvg($f)
        );

        $star1 = PointSet::star($p, 5, 2, 2*G::STAR_RADIUS_5_2);
        $star2 = $star1->copy();
        $box1 = PointSet::rectangle($p, 5, 5);
        $box2 = $box1->copy();

        $star1->rotate($p, $a);
        $box1->rotate($p, $a);
        G::rotate($p, $a, $star2, $box2);
        $this->assertEquals($star1, $star2);
        $this->assertEquals($box1, $box2);

        $star1->scale($p, 1.25);
        $box1->scale($p, 1.25);
        G::scale($p, 1.25, $star2, $box2);
        $this->assertEquals($star1, $star2);
        $this->assertEquals($box1, $box2);

        $star1->scaleX($p, 1.25);
        $box1->scaleX($p, 1.25);
        G::scaleX($p, 1.25, $star2, $box2);
        $this->assertEquals($star1, $star2);
        $this->assertEquals($box1, $box2);

        $star1->scaleY($p, 1.25);
        $box1->scaleY($p, 1.25);
        G::scaleY($p, 1.25, $star2, $box2);
        $this->assertEquals($star1, $star2);
        $this->assertEquals($box1, $box2);

        $star1->skewX($p, $a);
        $box1->skewX($p, $a);
        G::skewX($p, $a, $star2, $box2);
        $this->assertEquals($star1, $star2);
        $this->assertEquals($box1, $box2);

        $star1->skewY($p, $a);
        $box1->skewY($p, $a);
        G::skewY($p, $a, $star2, $box2);
        $this->assertEquals($star1, $star2);
        $this->assertEquals($box1, $box2);

        $star1->translate(2, 4);
        $box1->translate(2, 4);
        G::translate(2, 4, $star2, $box2);
        $this->assertEquals($star1, $star2);
        $this->assertEquals($box1, $box2);

        $star1->translateX(2);
        $box1->translateX(2);
        G::translateX(2, $star2, $box2);
        $this->assertEquals($star1, $star2);
        $this->assertEquals($box1, $box2);

        $star1->translateY(2);
        $box1->translateY(2);
        G::translateY(2, $star2, $box2);
        $this->assertEquals($star1, $star2);
        $this->assertEquals($box1, $box2);
    }
}
<?php
namespace Lib16\Graphics\Tests\Geometry;

use Lib16\Graphics\Geometry\ {
    Angle,
    BezierPath,
    Path,
    Point,
    Points
};
use Lib16\Graphics\Geometry\VectorGraphics as G;
use PHPUnit\Framework\TestCase;

class VectorGraphicsTest extends TestCase
{
    public function test()
    {
        $this->assertEquals(Angle::byDegrees(30), G::deg(30));
        $this->assertEquals(new Angle(0.2), G::rad(0.2));
        $this->assertEquals(new Point(0.1, 0.2), G::p(0.1, 0.2));
        $this->assertEquals(new Path(), G::path());
        $this->assertEquals(new BezierPath(), G::bezierPath());
        $p = G::p(1.25, 2.5);
        $a = G::deg(30);
        $a2 = G::deg(120);
        $this->assertEquals(
            Points::rectangle($p, 10, 5),
            G::rectangle($p, 10, 5)
        );
        $this->assertEquals(
            Points::roundedRectangle($p, 10, 5, 0.5),
            G::roundedRectangle($p, 10, 5, 0.5)
        );
        $this->assertEquals(
            Points::star($p, 5, 6, 6*Points::STAR_RADIUS_5_2),
            G::star($p, 5, 6, 6*G::STAR_RADIUS_5_2)
        );
        $this->assertEquals(
            Points::sector($p, $a, $a2, 1.2),
            G::sector($p, $a, $a2, 1.2)
        );
        $this->assertEquals(
            Points::ringSector($p, $a, $a2, 1.2, 0.8),
            G::ringSector($p, $a, $a2, 1.2, 0.8)
        );
        $this->assertEquals(
            Points::cross($p, 4, 8),
            G::cross($p, 4, 8)
        );
        $star = Points::star($p, 5, 2, 2*G::STAR_RADIUS_5_2);
        $box = Points::rectangle($p, 5, 5);
        $this->assertEquals(
            Points::rotate($p, $a, $star, $box),
            G::rotate($p, $a, $star, $box)
        );
        $this->assertEquals(
            Points::scale($p, 1.25, $star, $box),
            G::scale($p, 1.25, $star, $box)
        );
        $this->assertEquals(
            Points::scaleX($p, 1.25, $star, $box),
            G::scaleX($p, 1.25, $star, $box)
        );
        $this->assertEquals(
            Points::scaleY($p, 1.25, $star, $box),
            G::scaleY($p, 1.25, $star, $box)
        );
        $this->assertEquals(
            Points::skewX($p, $a, $star, $box),
            G::skewX($p, $a, $star, $box)
        );
        $this->assertEquals(
            Points::skewY($p, $a, $star, $box),
            G::skewY($p, $a, $star, $box)
        );
        $this->assertEquals(
            Points::translate(2, 4, $star, $box),
            G::translate(2, 4, $star, $box)
        );
        $this->assertEquals(
            Points::translateX(2, $star, $box),
            G::translateX(2, $star, $box)
        );
        $this->assertEquals(
            Points::translateY(2, $star, $box),
            G::translateY(2, $star, $box)
        );
    }
}
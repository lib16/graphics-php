<?php
namespace Lib16\Graphics\Geometry;

use Lib16\Graphics\Geometry\PathCommands\ {
    Arc,
    ClosePath
};
use Lib16\Graphics\Geometry\PathCommands\CubicCurveTo;
use Lib16\Graphics\Geometry\PathCommands\HorizontalLineTo;
use Lib16\Graphics\Geometry\PathCommands\LineTo;
use Lib16\Graphics\Geometry\PathCommands\MoveTo;
use Lib16\Graphics\Geometry\PathCommands\QuadraticCurveTo;
use Lib16\Graphics\Geometry\PathCommands\SmoothCubicCurveTo;
use Lib16\Graphics\Geometry\PathCommands\SmoothQuadraticCurveTo;
use Lib16\Graphics\Geometry\PathCommands\VerticalLineTo;
use Lib16\Utils\NumberFormatter;

class Path
{
    const QUADRANT_FACTOR = 0.5522847498;

    protected $commands = [];

    public function m(Point $point): self
    {
        $this->commands[] = new MoveTo($point);
        return $this;
    }

    public function l(Point $point): self
    {
        $this->commands[] = new LineTo($point);
        return $this;
    }

    public function h(float $x): self
    {
        $this->commands[] = new HorizontalLineTo($x);
        return $this;
    }

    public function v(float $y): self
    {
        $this->commands[] = new VerticalLineTo($y);
        return $this;
    }

    public function a(
        float $rx,
        float $ry,
        Angle $xAxisRotation = null,
        bool $largeArc,
        bool $sweep,
        Point $point
    ): self {
        $this->commands[] = new Arc(
            $rx,
            $ry,
            $xAxisRotation,
            $largeArc,
            $sweep,
            $point
        );
        return $this;
    }

    public function c(
        Point $controlPoint1,
        Point $controlPoint2,
        Point $point
    ): self {
        $this->commands[] = new CubicCurveTo(
            $controlPoint1,
            $controlPoint2,
            $point
        );
        return $this;
    }

    public function s(Point $controlPoint2, Point $point): self
    {
        $this->commands[] = new SmoothCubicCurveTo($controlPoint2, $point);
        return $this;
    }

    public function q(Point $controlPoint, Point $point): self
    {
        $this->commands[] = new QuadraticCurveTo($controlPoint, $point);
        return $this;
    }

    public function t(Point $point): self
    {
        $this->commands[] = new SmoothQuadraticCurveTo($point);
        return $this;
    }

    public function z(): self
    {
        $this->commands[] = new ClosePath();
        return $this;
    }

    public function polygon(PointSet $PointSet): self
    {
        $this->m($PointSet->getPoint(0));
        for ($i = 1; $i < $PointSet->count(); $i ++) {
            $this->l($PointSet->getPoint($i));
        }
        $this->z();
        return $this;
    }

    /**
     * Adds path commands for a regular (star) polygon.
     *
     * @param int $n
     *            Number of corners of the underlying polygon.
     */
    public function star(Point $center, int $n, float ...$radii): self
    {
        $PointSet = PointSet::star($center, $n, ...$radii);
        $this->polygon($PointSet);
        return $this;
    }

    public function rectangle(
        Point $corner,
        float $width,
        float $height,
        bool $reverseRotation = false
    ): self {
        if ($reverseRotation) {
            $corner->translateX($width);
            $width = -$width;
        }
        $this->m($corner);
        $this->h($corner->getX() + $width);
        $this->v($corner->getY() + $height);
        $this->h($corner->getX());
        $this->z();
        return $this;
    }

    public function roundedRectangle(
        Point $corner,
        float $width,
        float $height,
        float $radius,
        bool $reverseRotation = false
    ): self {
        if ($reverseRotation) {
            $corner->translateX($width);
            $width = -$width;
        }
        $rx = $width > 0 ? $radius : -$radius;
        $ry = $height > 0 ? $radius : -$radius;
        $x1 = $corner->getX();
        $x2 = $x1 + $rx;
        $x4 = $x1 + $width;
        $x3 = $x4 - $rx;
        $y1 = $corner->getY();
        $y2 = $y1 + $ry;
        $y4 = $y1 + $height;
        $y3 = $y4 - $ry;
        $sweep = !($width > 0 xor $height > 0);
        $this->m(new Point($x3, $y1));
        $this->a($radius, $radius, null, false, $sweep, new Point($x4, $y2));
        $this->v($y3);
        $this->a($radius, $radius, null, false, $sweep, new Point($x3, $y4));
        $this->h($x2);
        $this->a($radius, $radius, null, false, $sweep, new Point($x1, $y3));
        $this->v($y2);
        $this->a($radius, $radius, null, false, $sweep, new Point($x2, $y1));
        $this->z();
        return $this;
    }

    public function circle(
        Point $center,
        float $radius,
        bool $ccw = false
    ): self {
        return $this->ellipse($center, $radius, $radius, null, $ccw);
    }

    public function ellipse(
        Point $center,
        float $rx,
        float $ry,
        Angle $xAxisRotation = null,
        bool $ccw = false
    ): self {
        if (is_null($xAxisRotation)) {
            $xAxisRotation = new Angle(0);
        }
        $points = [
            $center->copy()
                ->translateX(+ $rx)
                ->rotate($center, $xAxisRotation),
            $center->copy()
                ->translateX(- $rx)
                ->rotate($center, $xAxisRotation)
        ];
        $sweep = ! $ccw;
        $this->m($points[0]);
        $this->a($rx, $ry, $xAxisRotation, false, $sweep, $points[1]);
        $this->a($rx, $ry, $xAxisRotation, false, $sweep, $points[0]);
        return $this;
    }

    public function sector(
        Point $center,
        Angle $start,
        Angle $stop,
        float $radius
    ): self {
        $point1 = $center->copy()->translateX($radius);
        $point2 = $point1->copy();
        $point1->rotate($center, $start);
        $point2->rotate($center, $stop);

        $this->m($center);
        $this->l($point1);

        $largeArc = $this->largeArc($start, $stop);
        $sweep = $start < $stop;
        $this->a($radius, $radius, null, $largeArc, $sweep, $point2);

        $this->z();
        return $this;
    }

    public function ringSector(
        Point $center,
        Angle $start,
        Angle $stop,
        float $radius,
        float $innerRadius
    ): self {
        $point1 = $center->copy()->translateX($radius);
        $point2 = $point1->copy();
        $point3 = $center->copy()->translateX($innerRadius);
        $point4 = $point3->copy();
        $point1->rotate($center, $start);
        $point2->rotate($center, $stop);
        $point3->rotate($center, $stop);
        $point4->rotate($center, $start);

        $this->m($point1);

        $largeArc = $this->largeArc($start, $stop);
        $sweep = $start < $stop;
        $this->a($radius, $radius, null, $largeArc, $sweep, $point2);

        $this->l($point3);

        $this->a($innerRadius, $innerRadius, null, $largeArc, !$sweep, $point4);

        $this->z();
        return $this;
    }

    public function toSvg(
        NumberFormatter $formatter,
        NumberFormatter $degreeFormatter
    ): string {
        $string = "";
        foreach ($this->commands as $command) {
            $string .= ' ' . $command->toSvg($formatter, $degreeFormatter);
        }
        $string = ltrim($string);
        return $string;
    }

    private function largeArc(Angle $start, Angle $stop): bool
    {
        return $stop->getRadians() - $start->getRadians() >= \pi();
    }
}

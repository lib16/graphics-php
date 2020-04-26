<?php
namespace Lib16\Graphics\Geometry;

use Lib16\Graphics\Geometry\PathCommands\ {
    Arc,
    HorizontalLineTo,
    VerticalLineTo
};

class Path extends PathCommands
{

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

    public function rectangle(Point $corner, float $width, float $height): self
    {
        $points = Points::rectangle($corner, $width, $height);
        $this->reorderPoints($points, 0);
        $this->m($points[0]);
        $this->h($points[1]->getX());
        $this->v($points[2]->getY());
        $this->h($points[3]->getX());
        $this->z();
        return $this;
    }

    public function roundedRectangle(
        Point $corner,
        float $width,
        float $height,
        float $radius
    ): self {
        $points = Points::roundedRectangle($corner, $width, $height, $radius);
        $this->reorderPoints($points, 0);
        $this->m($points[0]);
        $this->a($radius, $radius, null, false, ! $this->ccw, $points[1]);
        $this->v($points[2]->getY());
        $this->a($radius, $radius, null, false, ! $this->ccw, $points[3]);
        $this->h($points[4]->getX());
        $this->a($radius, $radius, null, false, ! $this->ccw, $points[5]);
        $this->v($points[6]->getY());
        $this->a($radius, $radius, null, false, ! $this->ccw, $points[7]);
        $this->z();
        return $this;
    }

    public function circle(Point $center, float $radius): self
    {
        return $this->ellipse($center, $radius, $radius);
    }

    public function ellipse(
        Point $center,
        float $rx,
        float $ry,
        Angle $xAxisRotation = null
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
        $sweep = ! $this->ccw;
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
        $points = Points::sector($center, $start, $stop, $radius);
        $this->reorderPoints($points, 1);
        $this->m($points[0]);
        $this->l($points[1]);
        $this->a(
            $radius,
            $radius,
            null,
            $this->largeArc($start, $stop),
            ! $this->ccw,
            $points[2]
        );
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
        $largeArc = $this->largeArc($start, $stop);
        if ($this->ccw) {
            $swap = $start;
            $start = $stop;
            $stop = $swap;
        }
        $points = Points::ringSector(
            $center,
            $start,
            $stop,
            $radius,
            $innerRadius
        );
        $this->m($points[0]);
        $this->a($radius, $radius, null, $largeArc, ! $this->ccw, $points[1]);
        $this->l($points[2]);
        $this->a(
            $innerRadius,
            $innerRadius,
            null,
            $largeArc,
            $this->ccw,
            $points[3]
        );
        $this->z();
        return $this;
    }

    private function largeArc(Angle $start, Angle $stop): bool
    {
        return $stop->getRadians() - $start->getRadians() >= \pi();
    }
}

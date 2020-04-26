<?php
namespace Lib16\Graphics\Geometry;

use HoffmannOSS\Arrays\Arrays;
use Lib16\Graphics\Geometry\PathCommands\ {
    ClosePath,
    CubicCurveTo,
    LineTo,
    MoveTo,
    QuadraticCurveTo,
    SmoothCubicCurveTo,
    SmoothQuadraticCurveTo
};
use Lib16\Utils\NumberFormatter;

class PathCommands
{

    protected $commands = [];

    protected $ccw = false;

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

    public function polygon(array $points): self
    {
        $this->m($points[0]);
        for ($i = 1; $i < count($points); $i ++) {
            $this->l($points[$i]);
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
        $points = Points::star($center, $n, ...$radii);
        $this->reorderPoints($points, 1);
        $this->polygon($points);
        return $this;
    }

    public function ccw($ccw = true): self
    {
        $this->ccw = $ccw;
        return $this;
    }

    public function cw($cw = true): self
    {
        return $this->ccw(! $cw);
    }

    public function getCommands(): array
    {
        return $this->commands;
    }

    public function toSvg(
        NumberFormatter $formatter,
        NumberFormatter $degreeFormatter
    ): string {
        $string = "";
        $first = true;
        foreach ($this->commands as $command) {
            if (! $first) {
                $string .= " ";
            } else {
                $first = false;
            }
            $string .= $command->toSvg($formatter, $degreeFormatter);
        }
        return $string;
    }

    protected function reorderPoints(array &$points, int $split)
    {
        if ($this->ccw) {
            Arrays::reverse($points, $split, count($points));
        }
    }
}

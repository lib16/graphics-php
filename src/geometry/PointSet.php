<?php
namespace Lib16\Graphics\Geometry;

use Lib16\Utils\NumberFormatter;

class PointSet implements \Iterator
{
    protected $points;

    private $position;

    public function __construct(Point ...$points)
    {
        $this->points = $points;
    }

    public static function create(Point ...$points)
    {
        return new static(...$points);
    }

    public static function rectangle(
        Point $corner,
        float $width,
        float $height,
        bool $reverseRotation = false
    ): self {
        if ($reverseRotation) {
            $corner->translateX($width);
            $width = -$width;
        }
        $points = [];
        $points[0] = $corner->copy();
        $points[1] = $points[0]->copy()->translateX($width);
        $points[2] = $points[1]->copy()->translateY($height);
        $points[3] = $points[0]->copy()->translateY($height);
        return static::create(...$points);
    }

    const STAR_RADIUS_5_2 = 0.38196601125011;

    const STAR_RADIUS_6_2 = 0.57735026918963;

    const STAR_RADIUS_7_2 = 0.6920214716301;

    const STAR_RADIUS_7_3 = 0.35689586789221;

    const STAR_RADIUS_8_2 = 0.76536686473018;

    const STAR_RADIUS_8_3 = 0.5411961001462;

    /**
     * Calculates the inner radius of a star polygon.
     *
     * Assumes that circumradius is 1.
     *
     * @param int $n
     *            Number of corners.
     * @param int $m
     *            2 <= m < n/2
     */
    public static function innerRadiusStar(int $n, int $m): float
    {
        return cos(pi() * $m / $n) / cos(pi() * ($m - 1) / $n);
    }

    public static function star(Point $center, int $n, float ...$radii): self
    {
        $points = [];
        $delta = deg2rad(360) / $n / count($radii);
        $angle = new Angle(0);
        for ($i = 0, $k = 0; $i < abs($n); $i ++) {
            foreach ($radii as $radius) {
                $points[$k++] = $center->copy()
                    ->translateY(- $radius)
                    ->rotate($center, $angle);
                $angle->add($delta);
            }
        }
        return static::create(...$points);
    }

    public function rotate(Point $center, Angle $angle): self
    {
        foreach ($this->points as $point) {
            $point->rotate($center, $angle);
        }
        return $this;
    }

    public function scale(Point $center, float $factor): self
    {
        foreach ($this->points as $point) {
            $point->scale($center, $factor);
        }
        return $this;
    }

    public function scaleX(Point $center, float $factor): self
    {
        foreach ($this->points as $point) {
            $point->scaleX($center, $factor);
        }
        return $this;
    }

    public function scaleY(Point $center, float $factor): self
    {
        foreach ($this->points as $point) {
            $point->scaleY($center, $factor);
        }
        return $this;
    }

    public function skewX(Point $center, Angle $angle): self
    {
        foreach ($this->points as $point) {
            $point->skewX($center, $angle);
        }
        return $this;
    }

    public function skewY(Point $center, Angle $angle): self
    {
        foreach ($this->points as $point) {
            $point->skewY($center, $angle);
        }
        return $this;
    }

    public function translate(float $deltaX, float $deltaY): self
    {
        foreach ($this->points as $point) {
            $point->translate($deltaX, $deltaY);
        }
        return $this;
    }

    public function translateX(float $deltaX): self
    {
        foreach ($this->points as $point) {
            $point->translateX($deltaX);
        }
        return $this;
    }

    public function translateY(float $deltaY): self
    {
        foreach ($this->points as $point) {
            $point->translateY($deltaY);
        }
        return $this;
    }

    public function toSvg(NumberFormatter $formatter): string
    {
        $svg = '';
        foreach ($this->points as $point) {
            $svg .= ' ' . $point->toSvg($formatter);
        }
        return $svg;
    }

    public function copy(): self
    {
        $points = [];
        foreach ($this->points as $point) {
            $points[] = $point->copy();
        }
        return PointSet::create(...$points);
    }

    public function getPoint(int $index): Point
    {
        return $this->points[$index];
    }

    public function setPoint(int $index, Point $point): self
    {
        $this->points[$index] = $point;
        return $this;
    }

    public function count(): int
    {
        return \count($this->points);
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid(): bool
    {
        return isset($this->points[$this->position]);
    }

    public function current(): Point
    {
        return $this->points[$this->position];
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function key(): int
    {
        return $this->position;
    }
}
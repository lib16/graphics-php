<?php
namespace Lib16\Graphics\Geometry;

use Lib16\Utils\NumberFormatter;

class Point
{

    private $x, $y;

    public function __construct(float $x = 0, float $y = 0)
    {
        $this->set($x, $y);
    }

    public function set(float $x, float $y): self
    {
        $this->x = $x;
        $this->y = $y;
        return $this;
    }

    public function rotate(Point $center, Angle $angle): self
    {
        $x = $this->x - $center->x;
        $y = $this->y - $center->y;
        $this->x = $x * $angle->getCos() - $y * $angle->getSin() + $center->x;
        $this->y = $y * $angle->getCos() + $x * $angle->getSin() + $center->y;
        return $this;
    }

    public function scale(Point $center, float $factor): self
    {
        return $this->scaleX($center, $factor)->scaleY($center, $factor);
    }

    public function scaleX(Point $center, float $factor): self
    {
        $this->x = self::scaleVal($this->x, $center->x, $factor);
        return $this;
    }

    public function scaleY(Point $center, float $factor): self
    {
        $this->y = self::scaleVal($this->y, $center->y, $factor);
        return $this;
    }

    public function skewX(Point $center, Angle $angle): self
    {
        $this->x += $angle->getTan() * ($this->y - $center->y);
        return $this;
    }

    public function skewY(Point $center, Angle $angle): self
    {
        $this->y += $angle->getTan() * ($this->x - $center->x);
        return $this;
    }

    public function translate(float $deltaX, float $deltaY): self
    {
        return $this->translateX($deltaX)->translateY($deltaY);
    }

    public function translateX(float $deltaX): self
    {
        $this->x += $deltaX;
        return $this;
    }

    public function translateY(float $deltaY): self
    {
        $this->y += $deltaY;
        return $this;
    }

    public function copy(): self
    {
        return new Point($this->x, $this->y);
    }

    public function getX(): float
    {
        return $this->x;
    }

    public function getY(): float
    {
        return $this->y;
    }

    public function toSvg(
        NumberFormatter $formatter,
        string $delimiter = ','
    ): string {
        return $formatter->format($this->x) . $delimiter . $formatter->format($this->y);
    }

    public function __get($coordinate)
    {
        return $this->{$coordinate};
    }

    private static function scaleVal(
        float $value,
        float $offset,
        float $factor
    ): float {
        return ($value - $offset) * $factor + $offset;
    }
}
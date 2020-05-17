<?php
namespace Lib16\Graphics\Geometry;

use Lib16\Utils\NumberFormatter;

class Angle
{

    private $radians, $sin, $cos, $tan;

    public function __construct(float $radians)
    {
        $this->set($radians);
    }

    public static function byDegrees(float $degrees): Angle
    {
        return new Angle(\deg2rad($degrees));
    }

    public function copy(): Angle
    {
        return clone $this;
    }

    public function set(float $radians): Angle
    {
        $this->radians = $radians;
        $this->sin = sin($radians);
        $this->cos = cos($radians);
        $this->tan = tan($radians);
        return $this;
    }

    public function setDegrees(float $degrees): Angle
    {
        $this->set(deg2rad($degrees));
        return $this;
    }

    public function add(float $radians): Angle
    {
        $this->set($this->radians + $radians);
        return $this;
    }

    public function addDegrees(float $degrees): Angle
    {
        $this->add(deg2rad($degrees));
        return $this;
    }

    public function getRadians(): float
    {
        return $this->radians;
    }

    public function getDegrees(): float
    {
        return rad2deg($this->radians);
    }

    public function getSin(): float
    {
        return $this->sin;
    }

    public function getCos(): float
    {
        return $this->cos;
    }

    public function getTan(): float
    {
        return $this->tan;
    }

    public function toSvg(NumberFormatter $formatter): string
    {
        return $formatter->format($this->getDegrees());
    }
}
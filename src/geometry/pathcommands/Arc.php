<?php
namespace Lib16\Graphics\Geometry\PathCommands;

use Lib16\Graphics\Geometry\ {
    Angle,
    Command,
    Point
};
use Lib16\Utils\NumberFormatter;

final class Arc extends Command
{

    private $rx, $ry;

    private $xAxisRotation;

    private $largeArc, $sweep;

    public function __construct(
        float $rx,
        float $ry,
        Angle $xAxisRotation = null,
        bool $largeArc,
        bool $sweep,
        Point $point
    ) {
        $this->rx = $rx;
        $this->ry = $ry;
        $this->xAxisRotation = $xAxisRotation;
        $this->largeArc = $largeArc;
        $this->sweep = $sweep;
        $this->points = [
            $point
        ];
    }

    public function getRx(): float
    {
        return $this->rx;
    }

    public function getRy(): float
    {
        return $this->ry;
    }

    public function getXAxisRotation(): Angle
    {
        return $this->xAxisRotation;
    }

    public function isLargeArc(): bool
    {
        return $this->largeArc;
    }

    public function isSweep(): bool
    {
        return $this->sweep;
    }

    public function toSvg(
        NumberFormatter $formatter,
        NumberFormatter $degreeFormatter
    ): string {
        return $this->letter('a', 'A')
            . $formatter->format($this->rx)
            . ' '
            . $formatter->format($this->ry)
            . ' '
            . ($this->xAxisRotation ? $this->xAxisRotation->toSvg($degreeFormatter) : '0')
            . ' '
            . ($this->largeArc ? '1 ' : '0 ')
            . ($this->sweep ? '1 ' : '0 ')
            . $this->points[0]->toSvg($formatter);
    }
}

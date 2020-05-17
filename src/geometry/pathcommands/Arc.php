<?php
namespace Lib16\Graphics\Geometry\PathCommands;

use Lib16\Graphics\Geometry\ {
    Angle,
    Command,
    Point,
    PointSet
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
        $this->PointSet = PointSet::create($point);
    }

    public function toSvg(
        NumberFormatter $formatter,
        NumberFormatter $degreeFormatter
    ): string {
        return $this->letter('a ', 'A ')
            . $formatter->format($this->rx)
            . ' '
            . $formatter->format($this->ry)
            . ' '
            . ($this->xAxisRotation ? $this->xAxisRotation->toSvg($degreeFormatter) : '0')
            . ' '
            . ($this->largeArc ? '1 ' : '0 ')
            . ($this->sweep ? '1' : '0')
            . $this->PointSet->toSvg($formatter);
    }
}

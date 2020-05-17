<?php
namespace Lib16\Graphics\Geometry\PathCommands;

use Lib16\Graphics\Geometry\Command;
use Lib16\Graphics\Geometry\Point;
use Lib16\Graphics\Geometry\PointSet;
use Lib16\Utils\NumberFormatter;

final class SmoothQuadraticCurveTo extends Command
{

    public function __construct(Point $point)
    {
        $this->PointSet = PointSet::create($point);
    }

    public function toSvg(
        NumberFormatter $formatter,
        NumberFormatter $degreeFormatter
    ): string {
        return $this->letter('t', 'T') . $this->PointSet->toSvg($formatter);
    }
}
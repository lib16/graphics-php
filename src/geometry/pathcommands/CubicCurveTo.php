<?php
namespace Lib16\Graphics\Geometry\PathCommands;

use Lib16\Graphics\Geometry\Command;
use Lib16\Graphics\Geometry\Point;
use Lib16\Graphics\Geometry\PointSet;
use Lib16\Utils\NumberFormatter;

final class CubicCurveTo extends Command
{

    public function __construct(
        Point $controlPoint1,
        Point $controlPoint2,
        Point $point
    ) {
        $this->PointSet = PointSet::create($controlPoint1, $controlPoint2, $point);
    }

    public function toSvg(
        NumberFormatter $formatter,
        NumberFormatter $degreeFormatter
    ): string {
        return $this->letter('c', 'C') . $this->PointSet->toSvg($formatter);
    }
}
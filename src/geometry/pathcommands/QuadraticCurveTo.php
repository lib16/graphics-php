<?php
namespace Lib16\Graphics\Geometry\PathCommands;

use Lib16\Graphics\Geometry\Command;
use Lib16\Graphics\Geometry\Point;
use Lib16\Graphics\Geometry\PointSet;
use Lib16\Utils\NumberFormatter;

final class QuadraticCurveTo extends Command
{

    public function __construct(Point $controlPoint, Point $point)
    {
        $this->PointSet = PointSet::create($controlPoint, $point);
    }

    public function toSvg(
        NumberFormatter $formatter,
        NumberFormatter $degreeFormatter
    ): string {
        return $this->letter('q', 'Q') . $this->PointSet->toSvg($formatter);
    }
}
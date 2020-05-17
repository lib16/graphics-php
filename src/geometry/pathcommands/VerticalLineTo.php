<?php
namespace Lib16\Graphics\Geometry\PathCommands;

use Lib16\Graphics\Geometry\Command;
use Lib16\Graphics\Geometry\PointSet;
use Lib16\Utils\NumberFormatter;

final class VerticalLineTo extends Command
{

    private $y;

    public function __construct(float $y)
    {
        $this->PointSet = PointSet::create();
        $this->y = $y;
    }

    public function toSvg(
        NumberFormatter $formatter,
        NumberFormatter $degreeFormatter
    ): string {
        return $this->letter('v ', 'V ') . $formatter->format($this->y);
    }
}
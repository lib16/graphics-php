<?php
namespace Lib16\Graphics\Geometry\PathCommands;

use Lib16\Graphics\Geometry\Command;
use Lib16\Graphics\Geometry\PointSet;
use Lib16\Utils\NumberFormatter;

final class ClosePath extends Command
{

    public function __construct()
    {
        $this->PointSet = PointSet::create();
    }

    public function toSvg(
        NumberFormatter $formatter,
        NumberFormatter $degreeFormatter
    ): string {
        return $this->letter('z', 'Z', '');
    }
}
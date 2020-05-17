<?php
namespace Lib16\Graphics\Geometry\PathCommands;

use Lib16\Graphics\Geometry\Command;
use Lib16\Graphics\Geometry\PointSet;
use Lib16\Utils\NumberFormatter;

final class HorizontalLineTo extends Command
{

    private $x;

    public function __construct(float $x)
    {
        $this->PointSet = PointSet::create();
        $this->x = $x;
    }

    public function toSvg(
        NumberFormatter $formatter,
        NumberFormatter $degreeFormatter
    ): string {
        return $this->letter('h ', 'H ') . $formatter->format($this->x);
    }
}
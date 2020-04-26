<?php
namespace Lib16\Graphics\Geometry\PathCommands;

use Lib16\Graphics\Geometry\Command;
use Lib16\Utils\NumberFormatter;

final class ClosePath extends Command
{

    public function __construct()
    {
        $this->points = [];
    }

    public function toSvg(
        NumberFormatter $formatter,
        NumberFormatter $degreeFormatter
    ): string {
        return $this->cmd('z', 'Z', '');
    }
}
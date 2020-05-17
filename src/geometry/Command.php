<?php
namespace Lib16\Graphics\Geometry;

use Lib16\Utils\NumberFormatter;

abstract class Command
{

    protected $PointSet;

    protected $relative = false;

    public function rel(): self
    {
        $this->relative = true;
        return $this;
    }

    public abstract function toSvg(
        NumberFormatter $formatter,
        NumberFormatter $degreeFormatter
    ): string;

    protected function letter(
        string $relativeCommand,
        string $absoluteCommand
    ): string {
        return ($this->relative ? $relativeCommand : $absoluteCommand);
    }
}

<?php

namespace Lib16\Graphics\Geometry\PathCommands;

use Lib16\Graphics\Geometry\Command;
use Lib16\Graphics\Geometry\Point;
use Lib16\Utils\NumberFormatter;

final class SmoothCubicCurveTo extends Command
{
	public function __construct(Point $controlPoint2, Point $point)
	{
		$this->points = [$controlPoint2, $point];
	}

	public function toSvg(NumberFormatter $formatter, NumberFormatter $degreeFormatter): string
	{
		return ($this->relative ? "s " : "S ")
				. $this->points[0]->toSvg($formatter) . ' '
				. $this->points[1]->toSvg($formatter);
	}
}
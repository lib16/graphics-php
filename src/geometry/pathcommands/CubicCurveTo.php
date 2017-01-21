<?php

namespace Lib16\Graphics\Geometry\PathCommands;

use Lib16\Graphics\Geometry\Command;
use Lib16\Graphics\Geometry\Point;
use Lib16\Utils\NumberFormatter;

final class CubicCurveTo extends Command
{
	public function __construct(Point $controlPoint1, Point $controlPoint2, Point $point)
	{
		$this->points = [$controlPoint1, $controlPoint2, $point];
	}

	public function toSvg(NumberFormatter $formatter, NumberFormatter $degreeFormatter): string
	{
		return ($this->relative ? "c " : "C ")
				. $this->points[0]->toSvg($formatter) . ' '
				. $this->points[1]->toSvg($formatter) . ' '
				. $this->points[2]->toSvg($formatter);
	}
}
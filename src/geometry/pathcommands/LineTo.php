<?php

namespace Lib16\Graphics\Geometry\PathCommands;

use Lib16\Graphics\Geometry\Command;
use Lib16\Graphics\Geometry\Point;
use Lib16\Utils\NumberFormatter;

final class LineTo extends Command
{
	public function __construct(Point $point)
	{
		$this->points = [$point];
	}

	public function toSvg(NumberFormatter $formatter, NumberFormatter $degreeFormatter): string
	{
		return ($this->relative ? "l " : "L ") . $this->points[0]->toSvg($formatter);
	}
}
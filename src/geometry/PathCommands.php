<?php

namespace Lib16\Graphics\Geometry;

use HoffmannOSS\Arrays\Arrays;
use Lib16\Graphics\Geometry\PathCommands\ClosePath;
use Lib16\Graphics\Geometry\PathCommands\CubicCurveTo;
use Lib16\Graphics\Geometry\PathCommands\LineTo;
use Lib16\Graphics\Geometry\PathCommands\MoveTo;
use Lib16\Graphics\Geometry\PathCommands\QuadraticCurveTo;
use Lib16\Graphics\Geometry\PathCommands\SmoothCubicCurveTo;
use Lib16\Graphics\Geometry\PathCommands\SmoothQuadraticCurveTo;
use Lib16\Utils\NumberFormatter;

class PathCommands
{
	protected $commands = [];
	protected $ccw = false;

	public function m(Point $point): self
	{
		$this->commands[] = new MoveTo($point);
		return $this;
	}

	public function l(Point $point): self
	{
		$this->commands[] = new LineTo($point);
		return $this;
	}

	public function c(Point $controlPoint1, Point $controlPoint2, Point $point): self
	{
		$this->commands[] = new CubicCurveTo($controlPoint1, $controlPoint2, $point);
		return $this;
	}

	public function s(Point $controlPoint2, Point $point): self
	{
		$this->commands[] = new SmoothCubicCurveTo($controlPoint2, $point);
		return $this;
	}

	public function q(Point $controlPoint, Point $point): self
	{
		$this->commands[] = new QuadraticCurveTo($controlPoint, $point);
		return $this;
	}

	public function t(Point $point): self
	{
		$this->commands[] = new SmoothQuadraticCurveTo($point);
		return $this;
	}

	public function z(): self
	{
		$this->commands[] = new ClosePath();
		return $this;
	}

	public function polygon(array $points): self
	{
		$this->m($points[0]);
		for ($i = 1; $i < count($points); $i++) {
			$this->l($points[$i]);
		}
		$this->z();
		return $this;
	}

	/**
	 * Adds path commands for a regular (star) polygon.
	 *
	 * @param  n  Number of corners of the underlying polygon.
	 */
	public function star(Point $center, int $n, float ...$radii): self
	{
		$points = Points::star($center, $n, ...$radii);
		$this->reorderPoints($points, 1);
		$this->polygon($points);
		return $this;
	}

	public function ccw(): self
	{
		$this->ccw = true;
		return $this;
	}

	public function cw(): self
	{
		$this->ccw = false;
		return $this;
	}

	public function getCommands(): array
	{
		return $this->commands;
	}

	public function toSvg(NumberFormatter $formatter, NumberFormatter $degreeFormatter): string
	{
		$string = "";
		$first = true;
		foreach ($this->commands as $command) {
			if (!$first) {
				$string .= " ";
			}
			else {
				$first = false;
			}
			$string .= $command->toSvg($formatter, $degreeFormatter);
		}
		return $string;
	}

	protected function reorderPoints(array &$points, int $split)
	{
		if ($this->ccw) {
			Arrays::reverse($points, $split, count($points));
		}
	}
}

<?php

namespace Lib16\Graphics\Geometry;

use Lib16\Utils\NumberFormatter;

abstract class Command
{
	protected $points;

	protected $relative = false;

	public function getPoints(): array
	{
		return $this->points;
	}

	public function rel(): self
	{
		$this->relative = true;
		return $this;
	}

	public function isRelative(): bool
	{
		return $this->relative;
	}

	public abstract function toSvg(
			NumberFormatter $formatter,
			NumberFormatter $degreeFormatter): string;
}

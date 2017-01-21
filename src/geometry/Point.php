<?php

namespace Lib16\Graphics\Geometry;

use Lib16\Utils\NumberFormatter;

class Point
{
	private $x, $y;

	public function __construct(float $x = 0, float $y = 0)
	{
		$this->set($x, $y);
	}

	public function set(float $x, float $y): Point
	{
		$this->x = $x;
		$this->y = $y;
		return $this;
	}

	public function rotate(Point $center, Angle $angle): Point
	{
		$x = $this->x - $center->x;
		$y = $this->y - $center->y;
		$this->x = $x * $angle->getCos() - $y * $angle->getSin() + $center->x;
		$this->y = $y * $angle->getCos() + $x * $angle->getSin() + $center->y;
		return $this;
	}

	public function scale(Point $center, float $factor): Point
	{
		return $this->scaleX($center, $factor)->scaleY($center, $factor);
	}

	public function scaleX(Point $center, float $factor): Point
	{
		$this->x = self::scaleVal($this->x, $center->x, $factor);
		return $this;
	}

	public function scaleY(Point $center, float $factor): Point
	{
		$this->y = self::scaleVal($this->y, $center->y, $factor);
		return $this;
	}

	public function skewX(Point $center, Angle $angle): Point
	{
		$this->x += $angle->getTan() * ($this->y - $center->y);
		return $this;
	}

	public function skewY(Point $center, Angle $angle): Point
	{
		$this->y += $angle->getTan() * ($this->x - $center->x);
		return $this;
	}

	public function translate(float $deltaX, float $deltaY): Point
	{
		return $this->translateX($deltaX)->translateY($deltaY);
	}

	public function translateX(float $deltaX): Point
	{
		$this->x += $deltaX;
		return $this;
	}

	public function translateY(float $deltaY): Point
	{
		$this->y += $deltaY;
		return $this;
	}

	public function copy(): Point
	{
		return new Point($this->x, $this->y);
	}

	public function getX(): float
	{
		return $this->x;
	}

	public function getY(): float
	{
		return $this->y;
	}

	public function toSvg(NumberFormatter $formatter): string
	{
		return $formatter->format($this->x) . "," . $formatter->format($this->y);
	}

	public function __get($coordinate)
	{
		return $this->{$coordinate};
	}

	private static function scaleVal(float $value, float $offset, float $factor): float
	{
		return ($value - $offset) * $factor + $offset;
	}
}
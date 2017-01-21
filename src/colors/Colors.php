<?php

namespace Lib16\Graphics\Colors;

class Colors
{
	public static function max(int $r, int $g, int $b): int
	{
		return max([$r, $g, $b]);
	}

	public static function min(int $r, int $g, int $b): int
	{
		return min([$r, $g, $b]);
	}

	public static function saturation(int $r, int $g, int $b): int
	{
		return self::max($r, $g, $b) - self::min($r, $g, $b);
	}

	public static function hue(int $r, int $g, int $b): float
	{
		$min = self::min($r, $g, $b);
		$max = self::max($r, $g, $b);
		if ($r == $g && $g == $b) {
			return 0;
		}
		if ($r == $max && $b == $min) {
			return self::delta($g, $min, $max);
		}
		if ($g == $max) {
			if ($b == $min) {
				return 120 - self::delta($r, $min, $max);
			}
			else {
				return 120 + self::delta($b, $min, $max);
			}
		}
		if ($b == $max) {
			if ($r == $min) {
				return 240 - self::delta($g, $min, $max);
			}
			else
			{
				return 240 + self::delta($r, $min, $max);
			}
		}
		return 360 - self::delta($b, $min, $max); // $r == $max && $g == $min
	}

	public static function grayValue(int $r, int $g , int $b,
			float $rFactor = 0.3, float $gFactor = 0.59, float $bFactor = 0.11): int
	{
		return round($rFactor * $r + $gFactor * $g + $bFactor * $b);
	}

	/**
	 * @return The array keys are r,g,b.
	 */
	public static function color(float $hue, int $saturation, int $white = 0): array
	{
		$hue /= 60;
		return [
			'r' => round($saturation * max([min([max([2 - $hue, $hue - 4]), 1]), 0])) + $white,
			'g' => round($saturation * max([min([min([4 - $hue, $hue]),     1]), 0])) + $white,
			'b' => round($saturation * max([min([min([6 - $hue, $hue - 2]), 1]), 0])) + $white
		];
	}

	private static function delta(int $med, int $min, int $max): float
	{
		return 60 * ($med - $min) / ($max - $min);
	}
}

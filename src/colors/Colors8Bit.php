<?php

namespace Lib16\Graphics\Colors;

class Colors8Bit
{
	public static function max(int $argb): int
	{
		return Colors::max(self::r($argb), self::g($argb), self::b($argb));
	}

	public static function min(int $argb): int
	{
		return Colors::min(self::r($argb), self::g($argb), self::b($argb));
	}

	public static function saturation(int $argb): int
	{
		return Colors::saturation(self::r($argb), self::g($argb), self::b($argb));
	}

	public static function hue(int $argb): float
	{
		return Colors::hue(self::r($argb), self::g($argb), self::b($argb));
	}

	public static function grayValue(int $argb,
			float $rFactor = 0.3, float $gFactor = 0.59, float $bFactor = 0.11): int
	{
		return Colors::grayValue(
				self::r($argb), self::g($argb), self::b($argb),
				$rFactor, $gFactor, $bFactor);
	}

	public static function gray(int $argb,
			float $rFactor = 0.3, float $gFactor = 0.59, float $bFactor = 0.11): int
	{
		$value = self::grayValue($argb, $rFactor, $gFactor, $bFactor);
		return self::argb($value, $value, $value, self::a($argb));
	}

	public static function color(float $hue, int $saturation, int $white = 0): int
	{
		$color = Colors::color($hue, $saturation, $white);
		return self::argb($color['r'], $color['g'], $color['b']);
	}

	public static function argb(int $red, int $green, int $blue, int $alpha = 255): int
	{
		return $blue | $green << 8 | $red << 16 | $alpha << 24;
	}

	public static function fromRgb(int $rgb, float $opacity = null): int
	{
		$a = is_null($opacity) ? 255 : max(0, min(255, round($opacity * 255)));
		return $rgb | $a << 24;
	}

	public static function r(int $argb): int
	{
		return $argb >> 16 & 0xff;
	}

	public static function g(int $argb): int
	{
		return $argb >> 8 & 0xff;
	}

	public static function b(int $argb): int
	{
		return $argb & 0xff;
	}

	public static function a(int $argb): int
	{
		return $argb >> 24 & 0xff;
	}
}

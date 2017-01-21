<?php

namespace Lib16\Graphics\Geometry;

class Points
{
	public static function rectangle(Point $corner, float $width, float $height): array
	{
		$points = array();
		$points[0] = $corner->copy();
		$points[1] = $points[0]->copy()->translateX($width);
		$points[2] = $points[1]->copy()->translateY($height);
		$points[3] = $points[0]->copy()->translateY($height);
		return $points;
	}

	public static function roundedRectangle(
			Point $corner, float $width, float $height, float $radius): array
	{
		$points = array();
		$points[7] = $corner->copy()->translateX($radius);
		$points[0] = $corner->copy()->translateX($width - $radius);
		$points[6] = $corner->copy()->translateY($radius);
		$points[5] = $corner->copy()->translateY($height - $radius);
		$points[1] = $points[6]->copy()->translateX($width);
		$points[2] = $points[5]->copy()->translateX($width);
		$points[4] = $points[7]->copy()->translateY($height);
		$points[3] = $points[0]->copy()->translateY($height);
		return $points;
	}

	const STAR_RADIUS_5_2 = 0.38196601125011;
	const STAR_RADIUS_6_2 = 0.57735026918963;
	const STAR_RADIUS_7_2 = 0.6920214716301;
	const STAR_RADIUS_7_3 = 0.35689586789221;
	const STAR_RADIUS_8_2 = 0.76536686473018;
	const STAR_RADIUS_8_3 = 0.5411961001462;

	/**
	 * Calculates the inner radius of a star polygon.
	 *
	 * Assumes that circumradius is 1.
	 *
	 * @param  int  n  Number of corners.
	 * @param  int  m  2 <= m < n/2
	 */
	public static function innerRadiusStar(int $n, int $m): float
	{
		return cos(pi() * $m / $n) / cos(pi() * ($m - 1) / $n);
	}

	public static function star(Point $center, int $n, float ...$radii): array
	{
		$points = array();
		$delta = deg2rad(360) / $n / count($radii);
		$angle = new Angle(0);
		for ($i = 0, $k = 0; $i < $n; $i++) {
			foreach ($radii as $radius) {
				$points[$k++] = $center->copy()->translateY(-$radius)->rotate($center, $angle);
				$angle->add($delta);
			}
		}
		return $points;
	}

	public static function sector(Point $center, Angle $start, Angle $stop, float $radius): array
	{
		$points = array();
		$points[0] = $center->copy();
		$points[1] = $center->copy()->translateX($radius)->rotate($center, $start);
		$points[2] = $center->copy()->translateX($radius)->rotate($center, $stop);
		return $points;
	}

	public static function ringSector(Point $center,
			Angle $start, Angle $stop, float $radius, float $innerRadius): array
	{
		$points = array();
		$points[0] = $center->copy()->translateX($radius)->rotate($center, $start);
		$points[1] = $center->copy()->translateX($radius)->rotate($center, $stop);
		$points[2] = $center->copy()->translateX($innerRadius)->rotate($center, $stop);
		$points[3] = $center->copy()->translateX($innerRadius)->rotate($center, $start);
		return $points;
	}

	public static function cross(Point $center, float $rx, float $ry): array
	{
		$points = array();
		$points[0] = $center->copy()->translateY(-$ry);
		$points[1] = $center->copy()->translateX($rx);
		$points[2] = $center->copy()->translateY($ry);
		$points[3] = $center->copy()->translateX(-$rx);
		return $points;
	}

	public static function rotate(Point $center, Angle $angle, array ...$points)
	{
		foreach ($points as $pointArray) {
			foreach ($pointArray as $point) {
				$point->rotate($center, $angle);
			}
		}
	}

	public static function scale(Point $center, float $factor, array ...$points)
	{
		foreach ($points as $pointArray) {
			foreach ($pointArray as $point) {
				$point->scale($center, $factor);
			}
		}
	}

	public static function scaleX(Point $center, float $factor, array ...$points)
	{
		foreach ($points as $pointArray) {
			foreach ($pointArray as $point) {
				$point->scaleX($center, $factor);
			}
		}
	}

	public static function scaleY(Point $center, float $factor, array ...$points)
	{
		foreach ($points as $pointArray) {
			foreach ($pointArray as $point) {
				$point->scaleY($center, $factor);
			}
		}
	}

	public static function skewX(Point $center, Angle $angle, array ...$points)
	{
		foreach ($points as $pointArray) {
			foreach ($pointArray as $point) {
				$point->skewX($center, $angle);
			}
		}
	}

	public static function skewY(Point $center, Angle $angle, array ...$points)
	{
		foreach ($points as $pointArray) {
			foreach ($pointArray as $point) {
				$point->skewY($center, $angle);
			}
		}
	}

	public static function translate(float $deltaX, float $deltaY, array ...$points)
	{
		foreach ($points as $pointArray) {
			foreach ($pointArray as $point) {
				$point->translate($deltaX, $deltaY);
			}
		}
	}

	public static function translateX(float $deltaX, array ...$points)
	{
		foreach ($points as $pointArray) {
			foreach ($pointArray as $point) {
				$point->translateX($deltaX);
			}
		}
	}

	public static function translateY(float $deltaY, array ...$points)
	{
		foreach ($points as $pointArray) {
			foreach ($pointArray as $point) {
				$point->translateY($deltaY);
			}
		}
	}
}
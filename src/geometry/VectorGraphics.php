<?php
namespace Lib16\Graphics\Geometry;

class VectorGraphics
{
    public static function deg(float $degrees): Angle
    {
        return Angle::byDegrees($degrees);
    }

    public static function rad(float $radians): Angle
    {
        return new Angle($radians);
    }

    public static function point(float $x = 0, float $y = 0): Point
    {
        return new Point($x, $y);
    }

    public static function p(float $x = 0, float $y = 0): Point
    {
        return static::point($x, $y);
    }

    public static function path(): Path
    {
        return new Path();
    }

    public static function bezierPath(): BezierPath
    {
        return new BezierPath();
    }

    public static function rectangle(
        Point $corner,
        float $width,
        float $height
    ): array {
        return Points::rectangle($corner, $width, $height);
    }

    public static function roundedRectangle(
        Point $corner,
        float $width,
        float $height,
        float $radius
    ): array {
        return Points::roundedRectangle($corner, $width, $height, $radius);
    }

    const STAR_RADIUS_5_2 = Points::STAR_RADIUS_5_2;

    const STAR_RADIUS_6_2 = Points::STAR_RADIUS_6_2;

    const STAR_RADIUS_7_2 = Points::STAR_RADIUS_7_2;

    const STAR_RADIUS_7_3 = Points::STAR_RADIUS_7_3;

    const STAR_RADIUS_8_2 = Points::STAR_RADIUS_8_2;

    const STAR_RADIUS_8_3 = Points::STAR_RADIUS_8_3;

    public static function star(Point $center, int $n, float ...$radii): array
    {
        return Points::star($center, $n, ...$radii);
    }

    public static function sector(
        Point $center,
        Angle $start,
        Angle $stop,
        float $radius
    ): array {
        return Points::sector($center, $start, $stop, $radius);
    }

    public static function ringSector(
        Point $center,
        Angle $start,
        Angle $stop,
        float $radius,
        float $innerRadius
    ): array {
        return Points::ringSector($center, $start, $stop, $radius, $innerRadius);
    }

    public static function cross(Point $center, float $rx, float $ry): array
    {
        return Points::cross($center, $rx, $ry);
    }

    public static function rotate(
        Point $center,
        Angle $angle,
        array ...$points
    ) {
        Points::rotate($center, $angle, ...$points);
    }

    public static function scale(
        Point $center,
        float $factor,
        array ...$points
    ) {
        Points::scale($center, $factor, ...$points);
    }

    public static function scaleX(
        Point $center,
        float $factor,
        array ...$points
    ) {
        Points::scaleX($center, $factor, ...$points);
    }

    public static function scaleY(
        Point $center,
        float $factor,
        array ...$points
    ) {
        Points::scaleY($center, $factor, ...$points);
    }

    public static function skewX(Point $center, Angle $angle, array ...$points)
    {
        Points::skewX($center, $angle, ...$points);
    }

    public static function skewY(Point $center, Angle $angle, array ...$points)
    {
        Points::skewY($center, $angle, ...$points);
    }

    public static function translate(
        float $deltaX,
        float $deltaY,
        array ...$points
    ) {
        Points::translate($deltaX, $deltaY, ...$points);
    }

    public static function translateX(float $deltaX, array ...$points)
    {
        Points::translateX($deltaX, ...$points);
    }

    public static function translateY(float $deltaY, array ...$points)
    {
        Points::translateX($deltaY, ...$points);
    }

}



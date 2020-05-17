<?php
namespace Lib16\Graphics\Geometry;

class VectorGraphics
{
    public static function angle(float $degrees): Angle
    {
        return Angle::byDegrees($degrees);
    }

    public static function deg(float $degrees): Angle
    {
        return static::angle($degrees);
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

    public static function rectangle(
        Point $corner,
        float $width,
        float $height,
        bool $reverseRotation = false
    ): PointSet {
        return PointSet::rectangle($corner, $width, $height, $reverseRotation);
    }

    const STAR_RADIUS_5_2 = PointSet::STAR_RADIUS_5_2;

    const STAR_RADIUS_6_2 = PointSet::STAR_RADIUS_6_2;

    const STAR_RADIUS_7_2 = PointSet::STAR_RADIUS_7_2;

    const STAR_RADIUS_7_3 = PointSet::STAR_RADIUS_7_3;

    const STAR_RADIUS_8_2 = PointSet::STAR_RADIUS_8_2;

    const STAR_RADIUS_8_3 = PointSet::STAR_RADIUS_8_3;

    public static function star(
        Point $center,
        int $n,
        float ...$radii
    ): PointSet {
        return PointSet::star($center, $n, ...$radii);
    }

    public static function innerRadiusStar(int $n, int $m): float
    {
        return PointSet::innerRadiusStar($n, $m);
    }

    public static function rotate(
        Point $center,
        Angle $angle,
        PointSet ...$pointSets
    ) {
        foreach ($pointSets as &$pointSet) {
            $pointSet->rotate($center, $angle);
        }
    }

    public static function scale(
        Point $center,
        float $factor,
        PointSet ...$pointSets
    ) {
        foreach ($pointSets as &$pointSet) {
            $pointSet->scale($center, $factor);
        }
    }

    public static function scaleX(
        Point $center,
        float $factor,
        PointSet ...$pointSets
    ) {
        foreach ($pointSets as &$pointSet) {
            $pointSet->scaleX($center, $factor);
        }
    }

    public static function scaleY(
        Point $center,
        float $factor,
        PointSet ...$pointSets
    ) {
        foreach ($pointSets as &$pointSet) {
            $pointSet->scaleY($center, $factor);
        }
    }

    public static function skewX(
        Point $center,
        Angle $angle,
        PointSet ...$pointSets
    ) {
        foreach ($pointSets as &$pointSet) {
            $pointSet->skewX($center, $angle);
        }
    }

    public static function skewY(
        Point $center,
        Angle $angle,
        PointSet ...$pointSets
    ) {
        foreach ($pointSets as &$pointSet) {
            $pointSet->skewY($center, $angle);
        }
    }

    public static function translate(
        float $deltaX,
        float $deltaY,
        PointSet ...$pointSets
    ) {
        foreach ($pointSets as &$pointSet) {
            $pointSet->translate($deltaX, $deltaY);
        }
    }

    public static function translateX(float $deltaX, PointSet ...$pointSets)
    {
        foreach ($pointSets as &$pointSet) {
            $pointSet->translateX($deltaX);
        }
    }

    public static function translateY(float $deltaY, PointSet ...$pointSets)
    {
        foreach ($pointSets as &$pointSet) {
            $pointSet->translateY($deltaY);
        }
    }

}



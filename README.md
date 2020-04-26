# `lib16/graphics-php`
Intended for use with lib16 SVG Builder.

[![Build Status](https://travis-ci.org/lib16/graphics-php.svg?branch=master)](https://travis-ci.org/lib16/graphics-php)

## Installation with Composer
This package is available on [packagist](https://packagist.org/packages/lib16/graphics), so you can use [Composer](https://getcomposer.org) to install it.
Run the following command in your shell:

```
composer require lib16/graphics
```

## Basic Usage
```php
<?php
require_once 'vendor/autoload.php';

use HoffmannOSS\Arrays\Arrays;
use Lib16\Utils\NumberFormatter;
use Lib16\Graphics\Geometry\ {
    Angle,
    Point,
    Points,
    Path
};

$center1 = new Point(100, 150);
$center2 = new Point(80, 290);
$center3 = new Point(210, 290);

$star = Points::star($center3, 7, 40, 40 * Points::STAR_RADIUS_7_3);
$rect = Points::rectangle(
    $center3->copy()->translate(-50, -52),
    100,
    100
);
Points::skewX($center3, Angle::byDegrees(-30), $star, $rect);
Arrays::reverse($star);

$path = (new Path())
    ->star(new Point(50, 50), 5, 40, 40 * Points::STAR_RADIUS_5_2)
    ->star(new Point(150, 50), 8, 40 * Points::STAR_RADIUS_8_3, 40)
    ->star(new Point(250, 50), 6, 30, 40, 40)
    ->star($center1, 6, 70)
    ->ccw()
    ->ellipse($center1, 60, 20, Angle::byDegrees(30))
    ->ellipse($center1, 60, 20, Angle::byDegrees(90))
    ->ellipse($center1, 60, 20, Angle::byDegrees(150))
    ->cw()
    ->rectangle(new Point(170, 95), 110, 110)
    ->ccw()
    ->roundedRectangle(new Point(175, 100), 100, 100, 20)
    ->cw()
    ->circle(new Point(225, 150), 45)
    ->sector($center2, Angle::byDegrees(30), Angle::byDegrees(175), 50)
    ->sector($center2, Angle::byDegrees(290), Angle::byDegrees(325), 50)
    ->ringSector($center2, Angle::byDegrees(175), Angle::byDegrees(275), 60, 50)
    ->polygon($rect)
    ->polygon($star)
    ->toSvg(new NumberFormatter(4), new NumberFormatter(2));



header('Content-type: image/svg+xml');
print '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 360">';
print '<rect x="0" y="0" width="300" height="360" fill="#2266aa" fill-opacity="0.5" />';
print '<path d="' . $path . '" fill="#2266aa" fill-opacity="0.5" stroke="#ffffff"/>';
print '</svg>';

```

the generated SVG:

```svg
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 360"><rect x="0" y="0" width="300" height="360" fill="#2266aa" fill-opacity="0.5" /><path d="M 50,10 L 58.9806,37.6393 L 88.0423,37.6393 L 64.5309,54.7214 L 73.5114,82.3607 L 50,65.2786 L 26.4886,82.3607 L 35.4691,54.7214 L 11.9577,37.6393 L 41.0194,37.6393 Z M 150,28.3522 L 165.3073,13.0448 L 165.3073,34.6927 L 186.9552,34.6927 L 171.6478,50 L 186.9552,65.3073 L 165.3073,65.3073 L 165.3073,86.9552 L 150,71.6478 L 134.6927,86.9552 L 134.6927,65.3073 L 113.0448,65.3073 L 128.3522,50 L 113.0448,34.6927 L 134.6927,34.6927 L 134.6927,13.0448 Z M 250,20 L 263.6808,12.4123 L 275.7115,19.3582 L 275.9808,35 L 289.3923,43.0541 L 289.3923,56.9459 L 275.9808,65 L 275.7115,80.6418 L 263.6808,87.5877 L 250,80 L 236.3192,87.5877 L 224.2885,80.6418 L 224.0192,65 L 210.6077,56.9459 L 210.6077,43.0541 L 224.0192,35 L 224.2885,19.3582 L 236.3192,12.4123 Z M 100,80 L 160.6218,115 L 160.6218,185 L 100,220 L 39.3782,185 L 39.3782,115 Z M 151.9615,180 A 60 20 30 0 0 48.0385,120 A 60 20 30 0 0 151.9615,180 M 100,210 A 60 20 90 0 0 100,90 A 60 20 90 0 0 100,210 M 48.0385,180 A 60 20 150 0 0 151.9615,120 A 60 20 150 0 0 48.0385,180 M 170,95 H 280 V 205 H 170 Z M 195,100 A 20 20 0 0 0 175,120 V 180 A 20 20 0 0 0 195,200 H 255 A 20 20 0 0 0 275,180 V 120 A 20 20 0 0 0 255,100 Z M 270,150 A 45 45 0 0 1 180,150 A 45 45 0 0 1 270,150 M 80,290 L 123.3013,315 A 50 50 0 0 1 30.1903,294.3578 Z M 80,290 L 97.101,243.0154 A 50 50 0 0 1 120.9576,261.3212 Z M 20.2283,295.2293 A 60 60 0 0 1 85.2293,230.2283 L 84.3578,240.1903 A 50 50 0 0 0 30.1903,294.3578 Z M 190.0222,238 L 290.0222,238 L 232.2872,338 L 132.2872,338 Z M 211.2319,277.1379 L 193.1256,265.0604 L 197.9161,286.8233 L 165.864,298.9008 L 193.6998,298.9008 L 171.8377,326.0388 L 201.7578,304.2758 L 206.5484,326.0388 L 216.0224,298.9008 L 243.8582,298.9008 L 225.752,286.8233 L 255.6721,265.0604 L 223.62,277.1379 L 233.094,250 Z" fill="#2266aa" fill-opacity="0.5" stroke="#ffffff"/></svg>
```

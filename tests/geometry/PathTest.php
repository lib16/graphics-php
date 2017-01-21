<?php

namespace Lib16\Graphics\Tests\Geometry;

use Lib16\Utils\NumberFormatter;
use Lib16\Graphics\Geometry\Angle;
use Lib16\Graphics\Geometry\Point;
use Lib16\Graphics\Geometry\Path;

require_once 'vendor/autoload.php';
require_once 'vendor/hoffmann-oss/arrays/src/Arrays.php';
require_once 'src/geometry/Path.php';

class PathTest extends \PHPUnit_Framework_TestCase
{
	public function provider(): array
	{
		$f = new NumberFormatter(4);
		$angles = [];
		$pointR1 = [];
		$pointR2 = [];
		$i = 0;
		foreach ([30, 60, 215] as $degrees) {
			$angles[$i] = Angle::byDegrees($degrees);
			$pointR1[$i] = (new Point(
					$angles[$i]->getCos() * 50 + 10,
					$angles[$i]->getSin() * 50 + 20))->toSvg($f);
			$pointR2[$i] = (new Point(
					$angles[$i]->getCos() * 25 + 10,
					$angles[$i]->getSin() * 25 + 20))->toSvg($f);
			$i++;
		}
		return [
			// @todo polygon
			// rectangle()
			[
				(new Path())->rectangle(new Point(10, 20), 100, 80),
				'M 10,20 H 110 V 100 H 10 Z'
			],
			[
				(new Path())->ccw()->rectangle(new Point(10, 20), 100, 80),
				'M 10,100 H 110 V 20 H 10 Z'
			],
			// roundedRectangle()
			[
				(new Path())->cw()->roundedRectangle(new Point(10, 20), 100, 80, 10),
				'M 100,20 A 10 10 0 0 1 110,30 ' .
				'V 90 A 10 10 0 0 1 100,100 ' .
				'H 20 A 10 10 0 0 1 10,90 ' .
				'V 30 A 10 10 0 0 1 20,20 Z'
			],
			[
				(new Path())->ccw()->roundedRectangle(new Point(10, 20), 100, 80, 10),
				'M 20,20 A 10 10 0 0 0 10,30 ' .
				'V 90 A 10 10 0 0 0 20,100 ' .
				'H 100 A 10 10 0 0 0 110,90 ' .
				'V 30 A 10 10 0 0 0 100,20 Z'
			],
			// circle()
			[
				(new Path())->circle(new Point(10, 20), 100),
				'M 110,20 A 100 100 0 0 1 -90,20 A 100 100 0 0 1 110,20'
			],
			[
				(new Path())->ccw()->circle(new Point(10, 20), 100),
				'M 110,20 A 100 100 0 0 0 -90,20 A 100 100 0 0 0 110,20'
			],
			// ellipse()
			[
				(new Path())->ellipse(new Point(10, 20), 100, 50),
				'M 110,20 A 100 50 0 0 1 -90,20 A 100 50 0 0 1 110,20'
			],
			[
				(new Path())->ccw()->ellipse(new Point(10, 20), 100, 50, Angle::byDegrees(90)),
				'M 10,120 A 100 50 90 0 0 10,-80 A 100 50 90 0 0 10,120'
			],
			// star
			[
				(new Path())->star(new Point(10, 20), 4, 100),
				'M 10,-80 L 110,20 L 10,120 L -90,20 Z'
			],
			[
				(new Path())->ccw()->star(new Point(10, 20), 4, 100),
				'M 10,-80 L -90,20 L 10,120 L 110,20 Z'
			],
			[
				(new Path())->star(new Point(10, 20), 2, 100, 50),
				'M 10,-80 L 60,20 L 10,120 L -40,20 Z'
			],
			[
				(new Path())->ccw()->star(new Point(10, 20), 2, 100, 50),
				'M 10,-80 L -40,20 L 10,120 L 60,20 Z'
			],
			[
				(new Path())->star(new Point(10, 20), 1, 100, 50, 100, 50),
				'M 10,-80 L 60,20 L 10,120 L -40,20 Z'
			],
			[
				(new Path())->ccw()->star(new Point(10, 20), 1, 100, 50, 100, 50),
				'M 10,-80 L -40,20 L 10,120 L 60,20 Z'
			],
			// sector()
			[
				(new Path())->sector(new Point(10, 20), $angles[0], $angles[1], 50),
				'M 10,20 L ' . $pointR1[0] . ' A 50 50 0 0 1 ' . $pointR1[1] . ' Z'
			],
			[
				(new Path())->sector(new Point(10, 20), $angles[0], $angles[2], 50),
				'M 10,20 L ' . $pointR1[0] . ' A 50 50 0 1 1 ' . $pointR1[2] . ' Z'
			],
			[
				(new Path())->ccw()->sector(new Point(10, 20), $angles[0], $angles[1], 50),
				'M 10,20 L ' . $pointR1[1] . ' A 50 50 0 0 0 ' . $pointR1[0] . ' Z'
			],
			// ringSector()
			[
				(new Path())->ringSector(new Point(10, 20), $angles[0], $angles[1], 50, 25),
				'M ' . $pointR1[0] . ' A 50 50 0 0 1 ' . $pointR1[1] . ' ' .
				'L ' . $pointR2[1] . ' A 25 25 0 0 0 ' . $pointR2[0] . ' Z'
			],
			[
				(new Path())->ringSector(new Point(10, 20), $angles[0], $angles[2], 50, 25),
				'M ' . $pointR1[0] . ' A 50 50 0 1 1 ' . $pointR1[2] . ' ' .
				'L ' . $pointR2[2] . ' A 25 25 0 1 0 ' . $pointR2[0] . ' Z'
			],
			[
				(new Path())->ccw()->ringSector(new Point(10, 20), $angles[0], $angles[1], 50, 25),
				'M ' . $pointR1[1] . ' A 50 50 0 0 0 ' . $pointR1[0] . ' ' .
				'L ' . $pointR2[0] . ' A 25 25 0 0 1 ' . $pointR2[1] . ' Z'
			]
		];
	}

	/**
	 * @dataProvider provider
	 */
	public function test(Path $path, string $expected)
	{
		$f = new NumberFormatter(4);
		$this->assertEquals($expected, $path->toSvg($f, $f));
	}
}
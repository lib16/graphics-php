<?php

namespace Lib16\Graphics\Tests\Geometry;

use Lib16\Graphics\Geometry\Angle;
use Lib16\Graphics\Geometry\Point;
use Lib16\Graphics\Geometry\Points;

require_once 'vendor/autoload.php';

class PointsTest extends \PHPUnit_Framework_TestCase
{
	public function provider(): array
	{
		$p1 = new Point(10, 20);
		$a1 = Angle::byDegrees(45);
		$a2 = Angle::byDegrees(135);
		$l1 = sin(deg2rad(45)) * 100;
		$l2 = $l1 / 2;

		return [
			[
				Points::rectangle($p1, 100, 80),
				[[10, 20], [110, 20], [110, 100], [10, 100]]
			],
			[
				Points::roundedRectangle($p1, 100, 80, 10),
				[
					[100, 20], [110, 30], [110, 90], [100, 100],
					[20, 100], [10, 90], [10, 30], [20, 20]
				]
			],
			[
				Points::star($p1, 4, 100),
				[[10, -80], [110, 20], [10, 120], [-90, 20]]
			],
			[
				Points::star($p1, 1, 100, 50, 100, 50),
				[[10, -80], [60, 20], [10, 120], [-40, 20]]
			],
			[
				Points::sector($p1, $a1, $a2, 100),
				[[10, 20], [10+$l1, 20+$l1], [10-$l1, 20+$l1]]
			],
			[
				Points::ringSector($p1, $a1, $a2, 100, 50),
				[[10+$l1, 20+$l1], [10-$l1, 20+$l1], [10-$l2, 20+$l2], [10+$l2, 20+$l2]]
			],
			[
				Points::cross($p1, 40, 30),
				[[10, -10], [50, 20], [10, 50], [-30, 20]]
			]
		];
	}

	/**
	 * @dataProvider provider
	 */
	public function test(array $actual, array $expected)
	{
		for ($i = 0; $i < count($expected); $i++) {
			$this->assertEquals($actual[$i]->x, $expected[$i][0], 0.01);
			$this->assertEquals($actual[$i]->y, $expected[$i][1], 0.01);
		}
	}
}
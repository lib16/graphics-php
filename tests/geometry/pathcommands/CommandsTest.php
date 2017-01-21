<?php

namespace Lib16\Graphics\Tests\Geometry\PathCommands;

use Lib16\Utils\NumberFormatter;
use Lib16\Graphics\Geometry\Angle;
use Lib16\Graphics\Geometry\Point;
use Lib16\Graphics\Geometry\Command;
use Lib16\Graphics\Geometry\PathCommands\MoveTo;
use Lib16\Graphics\Geometry\PathCommands\LineTo;
use Lib16\Graphics\Geometry\PathCommands\HorizontalLineTo;
use Lib16\Graphics\Geometry\PathCommands\VerticalLineTo;
use Lib16\Graphics\Geometry\PathCommands\CubicCurveTo;
use Lib16\Graphics\Geometry\PathCommands\SmoothCubicCurveTo;
use Lib16\Graphics\Geometry\PathCommands\QuadraticCurveTo;
use Lib16\Graphics\Geometry\PathCommands\SmoothQuadraticCurveTo;
use Lib16\Graphics\Geometry\PathCommands\Arc;
use Lib16\Graphics\Geometry\PathCommands\ClosePath;

require_once 'vendor/autoload.php';

class CommandsTest extends \PHPUnit_Framework_TestCase
{
	public function provider(): array
	{
		$p1 = new Point(10, 20);
		$p2 = new Point(30, 40);
		$p3 = new Point(50, 60);
		$a = Angle::byDegrees(45);

		return [
			[new MoveTo(new Point(1.23456, 78.9)), "M 1.2346,78.9"],
			[new LineTo(new Point(1.23456, 78.9)), "L 1.2346,78.9"],
			[new HorizontalLineTo(100), "H 100"],
			[new VerticalLineTo(100), "V 100"],
			[new CubicCurveTo($p1, $p2, $p3), "C 10,20 30,40 50,60"],
			[new SmoothCubicCurveTo($p1, $p2), "S 10,20 30,40"],
			[new QuadraticCurveTo($p1, $p2), "Q 10,20 30,40"],
			[new SmoothQuadraticCurveTo($p1), "T 10,20"],
			[new Arc(10, 20, $a, true, false, $p1), "A 10 20 45 1 0 10,20"],
			[new Arc(10, 20, null, false, true, $p1), "A 10 20 0 0 1 10,20"],
			[new ClosePath(), "Z"],
		];
	}

	/**
	 * @dataProvider provider
	 */
	public function test(Command $actual, string $expected)
	{
		$f = new NumberFormatter(4);
		$this->assertEquals($expected, $actual->toSvg($f, $f));
		$this->assertEquals(\strtolower($expected), $actual->rel()->toSvg($f, $f));
	}
}

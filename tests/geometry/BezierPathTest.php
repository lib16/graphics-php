<?php

namespace Lib16\Graphics\Geometry;

use Lib16\Utils\NumberFormatter;

use Lib16\Graphics\Geometry\Angle;
use Lib16\Graphics\Geometry\Point;
use Lib16\Graphics\Geometry\Path;

require_once 'vendor/autoload.php';
require_once 'vendor/hoffmann-oss/arrays/src/Arrays.php';
require_once 'src/geometry/Path.php';

class BezierPathTest extends \PHPUnit_Framework_TestCase
{
	public function provider(): array
	{
		$f = new NumberFormatter(4);
		$a45 = Angle::byDegrees(45);
		$c = new Point();
		$s2 = $f->format(10 * sqrt(2));
		$cp1 = $f->format(10 * BezierPath::QUADRANT_FACTOR);
		$cp2 = $f->format(40 + 10 * BezierPath::QUADRANT_FACTOR);

		return [
			// rectangle()
			[
				(new BezierPath())->rectangle(new Point(10, 20), 100, 80),
				'M 10,20 L 110,20 L 110,100 L 10,100 Z'
			],
			[
				(new BezierPath())->ccw()->rectangle(new Point(10, 20), 100, 80),
				'M 10,100 L 110,100 L 110,20 L 10,20 Z'
			],
			// roundedRectangle()
			[
				(new BezierPath())->roundedRectangle(new Point(-50, -50), 100, 100, 10),
				'M 40,-50'
				. ' C ' . $cp2 . ',-50 50,-' . $cp2 . ' 50,-40'
				. ' L 50,40'
				. ' C 50,' . $cp2 . ' ' . $cp2 . ',50 40,50'
				. ' L -40,50'
				. ' C -' . $cp2 . ',50 -50,' . $cp2 . ' -50,40'
				. ' L -50,-40'
				. ' C -50,-' . $cp2 . ' -' . $cp2 . ',-50 -40,-50'
				. ' Z'
			],
			[
				(new BezierPath())->ccw()->roundedRectangle(new Point(-50, -50), 100, 100, 10),
				'M -40,-50'
				. ' C -' . $cp2 . ',-50 -50,-' . $cp2 . ' -50,-40'
				. ' L -50,40'
				. ' C -50,' . $cp2 . ' -' . $cp2 . ',50 -40,50'
				. ' L 40,50'
				. ' C ' . $cp2 . ',50 50,' . $cp2 . ' 50,40'
				. ' L 50,-40'
				. ' C 50,-' . $cp2 . ' ' . $cp2 . ',-50 40,-50'
				. ' Z'
			],
			// ellipse()
			[
				(new BezierPath())->ellipse(new Point(0, 0), 10, 10),
				'M 0,-10'
				. ' C ' . $cp1 . ',-10 10,-' . $cp1 . ' 10,0'
				. ' C 10,' . $cp1 . ' ' . $cp1 . ',10 0,10'
				. ' C -' . $cp1 . ',10 -10,' . $cp1 . ' -10,0'
				. ' C -10,-' . $cp1 . ' -' . $cp1 . ',-10 0,-10'
			],
			[
				(new BezierPath())->ccw()->ellipse(new Point(0, 0), 10, 10),
				'M 0,-10'
				. ' C -' . $cp1 . ',-10 -10,-' . $cp1 . ' -10,0'
				. ' C -10,' . $cp1 . ' -' . $cp1 . ',10 0,10'
				. ' C ' . $cp1 . ',10 10,' . $cp1 . ' 10,0'
				. ' C 10,-' . $cp1 . ' ' . $cp1 . ',-10 0,-10'
			],
			[
				(new BezierPath())->circle(new Point(0, 0), 10),
				'M 0,-10'
				. ' C ' . $cp1 . ',-10 10,-' . $cp1 . ' 10,0'
				. ' C 10,' . $cp1 . ' ' . $cp1 . ',10 0,10'
				. ' C -' . $cp1 . ',10 -10,' . $cp1 . ' -10,0'
				. ' C -10,-' . $cp1 . ' -' . $cp1 . ',-10 0,-10'
			],
			[
				(new BezierPath())->ccw()->circle(new Point(0, 0), 10),
				'M 0,-10'
				. ' C -' . $cp1 . ',-10 -10,-' . $cp1 . ' -10,0'
				. ' C -10,' . $cp1 . ' -' . $cp1 . ',10 0,10'
				. ' C ' . $cp1 . ',10 10,' . $cp1 . ' 10,0'
				. ' C 10,-' . $cp1 . ' ' . $cp1 . ',-10 0,-10'
			],
			// star
			[
				(new BezierPath())->star(new Point(10, 20), 4, 100),
				'M 10,-80 L 110,20 L 10,120 L -90,20 Z'
			],
			[
				(new BezierPath())->ccw()->star(new Point(10, 20), 4, 100),
				'M 10,-80 L -90,20 L 10,120 L 110,20 Z'
			],
			[
				(new BezierPath())->star(new Point(10, 20), 2, 100, 50),
				'M 10,-80 L 60,20 L 10,120 L -40,20 Z'
			],
			[
				(new BezierPath())->ccw()->star(new Point(10, 20), 2, 100, 50),
				'M 10,-80 L -40,20 L 10,120 L 60,20 Z'
			],
			[
				(new BezierPath())->star(new Point(10, 20), 1, 100, 50, 100, 50),
				'M 10,-80 L 60,20 L 10,120 L -40,20 Z'
			],
			[
				(new BezierPath())->ccw()->star(new Point(10, 20), 1, 100, 50, 100, 50),
				'M 10,-80 L -40,20 L 10,120 L 60,20 Z'
			],
			// Transformations
			[
				(new BezierPath())->rectangle(new Point(-10, -10), 20, 20)->rotate($c, $a45),
				'M 0,-' . $s2 . ' L ' . $s2 . ',0 L 0,' . $s2 . ' L -' . $s2 . ',0 Z'
			],
			[
				(new BezierPath())->rectangle(new Point(-10, -10), 20, 20)->scale($c, 2),
				'M -20,-20 L 20,-20 L 20,20 L -20,20 Z'
			],
			[
				(new BezierPath())->rectangle(new Point(-10, -10), 20, 20)->scaleX($c, -1),
				'M 10,-10 L -10,-10 L -10,10 L 10,10 Z'
			],
			[
				(new BezierPath())->rectangle(new Point(-10, -10), 20, 20)->scaleY($c, -1),
				'M -10,10 L 10,10 L 10,-10 L -10,-10 Z'
			],
			[
				(new BezierPath())->rectangle(new Point(-10, -10), 20, 20)->skewX($c, $a45),
				'M -20,-10 L 0,-10 L 20,10 L 0,10 Z'
			],
			[
				(new BezierPath())->rectangle(new Point(-10, -10), 20, 20)->skewY($c, $a45),
				'M -10,-20 L 10,0 L 10,20 L -10,0 Z'
			],
			[
				(new BezierPath())->rectangle(new Point(-10, -10), 20, 20)->translate(5, 15),
				'M -5,5 L 15,5 L 15,25 L -5,25 Z'
			],
			[
				(new BezierPath())->rectangle(new Point(-10, -10), 20, 20)->translateX(5),
				'M -5,-10 L 15,-10 L 15,10 L -5,10 Z'
			],
			[
				(new BezierPath())->rectangle(new Point(-10, -10), 20, 20)->translateY(15),
				'M -10,5 L 10,5 L 10,25 L -10,25 Z'
			],
		];
	}

	/**
	 * @dataProvider provider
	 */
	public function test(BezierPath $path, string $expected)
	{
		$f = new NumberFormatter(4);
		$this->assertEquals($expected, $path->toSvg($f, $f));
	}
}

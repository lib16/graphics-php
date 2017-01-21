<?php

namespace Lib16\Graphics\Colors;

require_once 'vendor/autoload.php';

class ColorsTest extends \PHPUnit_Framework_TestCase
{
	public function saturationProvider(): array
	{
		return [
			[255, 255, 255, 0],
			[200, 150, 100, 100],
			[255, 210, 0, 255],
			[1000, 500, 0, 1000]
		];
	}

	/**
	 * @dataProvider saturationProvider
	 */
	public function testSaturation(int $r, int $g, int $b, int $saturation)
	{
		$this->assertEquals($saturation, Colors::saturation($r, $g, $b));
	}

	public function hueProvider(): array
	{
		return [
			[200, 200, 200, 0],
			[200, 100, 100, 0],
			[255, 235, 195, 40],
			[235, 235, 195, 60],
			[235, 255, 195, 80],
			[195, 235, 195, 120],
			[0, 60, 40, 160],
			[10, 235, 235, 180],
			[0, 40, 60, 200],
			[195, 195, 255, 240],
			[235, 195, 255, 280],
			[255, 195, 255, 300],
			[255, 195, 235, 320],
			[255, 195, 225, 330],
			[255, 195, 215, 340],
			[1000, 500, 0, 30]
		];
	}

	/**
	 * @dataProvider hueProvider
	 */
	public function testHue(int $r, int $g, int $b, float $hue)
	{
		$this->assertEquals($hue, Colors::hue($r, $g, $b));
	}

	public function grayValueProvider(): array
	{
		return [
			[255, 255, 255, 255],
			[200, 200, 200, 200],
			[0, 0, 0, 0],
			[1000, 1000, 1000, 1000]
		];
	}

	/**
	 * @dataProvider grayValueProvider
	 */
	public function testGrayValue(int $r, int $g, int $b, int $grayValue)
	{
		$this->assertEquals($grayValue, Colors::grayValue($r, $g, $b));
	}

	public function colorProvider()
	{
		return [
			[0, 90, 0, ['r' => 90, 'g' => 0, 'b' => 0]],
			[20, 90, 0, ['r' => 90, 'g' => 30, 'b' => 0]],
			[40, 90, 0, ['r' => 90, 'g' => 60, 'b' => 0]],
			[60, 90, 0, ['r' => 90, 'g' => 90, 'b' => 0]],
			[80, 90, 0, ['r' => 60, 'g' => 90, 'b' => 0]],
			[100, 90, 0, ['r' => 30, 'g' => 90, 'b' => 0]],
			[120, 90, 0, ['r' => 0, 'g' => 90, 'b' => 0]],
			[140, 90, 0, ['r' => 0, 'g' => 90, 'b' => 30]],
			[160, 90, 0, ['r' => 0, 'g' => 90, 'b' => 60]],
			[180, 90, 0, ['r' => 0, 'g' => 90, 'b' => 90]],
			[210, 90, 0, ['r' => 0, 'g' => 45, 'b' => 90]],
			[240, 90, 0, ['r' => 0, 'g' => 0, 'b' => 90]],
			[270, 90, 0, ['r' => 45, 'g' => 0, 'b' => 90]],
			[280, 90, 0, ['r' => 60, 'g' => 0, 'b' => 90]],
			[300, 90, 0, ['r' => 90, 'g' => 0, 'b' => 90]],
			[330, 90, 0, ['r' => 90, 'g' => 0, 'b' => 45]],
			[330, 90, 30, ['r' => 120, 'g' => 30, 'b' => 75]]
		];
	}

	/**
	 * @dataProvider colorProvider
	 */
	public function testColor(float $hue, int $saturation, int $white, array $expected)
	{
		$this->assertEquals($expected, Colors::color($hue, $saturation, $white));
	}
}

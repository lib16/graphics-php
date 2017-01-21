<?php

namespace Lib16\Graphics\Colors;

require_once 'vendor/autoload.php';

class Colors8BitTest extends \PHPUnit_Framework_TestCase
{
	public function saturationProvider(): array
	{
		return [
			[Colors8Bit::argb(255, 255, 255), 0],
			[Colors8Bit::argb(200, 150, 100), 100],
			[Colors8Bit::argb(255, 210, 0), 255]
		];
	}

	/**
	 * @dataProvider saturationProvider
	 */
	public function testSaturation(int $argb, int $saturation)
	{
		$this->assertEquals($saturation, Colors8Bit::saturation($argb));
	}

	public function hueProvider(): array
	{
		return [
			[Colors8Bit::argb(200, 200, 200), 0],
			[Colors8Bit::argb(200, 100, 100), 0],
			[Colors8Bit::argb(255, 235, 195), 40],
			[Colors8Bit::argb(235, 235, 195), 60],
			[Colors8Bit::argb(235, 255, 195), 80],
			[Colors8Bit::argb(195, 235, 195), 120],
			[Colors8Bit::argb(0, 60, 40), 160],
			[Colors8Bit::argb(10, 235, 235), 180],
			[Colors8Bit::argb(0, 40, 60), 200],
			[Colors8Bit::argb(195, 195, 255), 240],
			[Colors8Bit::argb(235, 195, 255), 280],
			[Colors8Bit::argb(255, 195, 255), 300],
			[Colors8Bit::argb(255, 195, 235), 320],
			[Colors8Bit::argb(255, 195, 225), 330],
			[Colors8Bit::argb(255, 195, 215), 340]
		];
	}

	/**
	 * @dataProvider hueProvider
	 */
	public function testHue(int $argb, float $hue)
	{
		$this->assertEquals($hue, Colors8Bit::hue($argb));
	}

	public function grayValueProvider(): array
	{
		return [
			[Colors8Bit::argb(255, 255, 255), 255],
			[Colors8Bit::argb(200, 200, 200), 200],
			[Colors8Bit::argb(0, 0, 0), 0]
		];
	}

	/**
	 * @dataProvider grayValueProvider
	 */
	public function testGrayValue(int $argb, int $grayValue)
	{
		$this->assertEquals($grayValue, Colors8Bit::grayValue($argb));
	}

	public function colorProvider(): array
	{
		return [
			[0, 90, 0, Colors8Bit::argb(90, 0, 0)],
			[20, 90, 0, Colors8Bit::argb(90, 30, 0)],
			[40, 90, 0, Colors8Bit::argb(90, 60, 0)],
			[60, 90, 0, Colors8Bit::argb(90, 90, 0)],
			[80, 90, 0, Colors8Bit::argb(60, 90, 0)],
			[100, 90, 0, Colors8Bit::argb(30, 90, 0)],
			[120, 90, 0, Colors8Bit::argb(0, 90, 0)],
			[140, 90, 0, Colors8Bit::argb(0, 90, 30)],
			[160, 90, 0, Colors8Bit::argb(0, 90, 60)],
			[180, 90, 0, Colors8Bit::argb(0, 90, 90)],
			[210, 90, 0, Colors8Bit::argb(0, 45, 90)],
			[240, 90, 0, Colors8Bit::argb(0, 0, 90)],
			[270, 90, 0, Colors8Bit::argb(45, 0, 90)],
			[280, 90, 0, Colors8Bit::argb(60, 0, 90)],
			[300, 90, 0, Colors8Bit::argb(90, 0, 90)],
			[330, 90, 0, Colors8Bit::argb(90, 0, 45)],
			[330, 90, 30, Colors8Bit::argb(120, 30, 75)]
		];
	}

	/**
	 * @dataProvider colorProvider
	 */
	public function testColor(float $hue, int $saturation, int $white, int $expected)
	{
		$this->assertEquals($expected, Colors8Bit::color($hue, $saturation, $white));
	}

	public function testArgb()
	{
		$c = Colors8Bit::argb(50, 100, 150, 200);
		$actual = [Colors8Bit::r($c), Colors8Bit::g($c), Colors8bit::b($c), Colors8Bit::a($c)];
		$expected = [50, 100, 150, 200];
		$this->assertEquals($expected, $actual);
	}

	public function fromRgbProvider(): array
	{
		return [
			[Colors8Bit::fromRgb(0x007fff), Colors8Bit::argb(0, 127, 255)],
			[Colors8Bit::fromRgb(0x007fff, 0), Colors8Bit::argb(0, 127, 255, 0)],
			[Colors8Bit::fromRgb(0x007fff, 0.5), Colors8Bit::argb(0, 127, 255, 128)],
			[Colors8Bit::fromRgb(0x007fff, 1), Colors8Bit::argb(0, 127, 255, 255)]
		];
	}

	/**
	 * @dataProvider fromRgbProvider
	 */
	public function testFromRgb(int $actual, int $expected)
	{
		$this->assertEquals($expected, $actual);
	}
}

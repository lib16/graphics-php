<?php
namespace Lib16\Graphics\Geometry;

class BezierPath extends PathCommands
{

    const QUADRANT_FACTOR = 0.5522847498;

    public function rectangle(Point $corner, float $width, float $height): self
    {
        $points = Points::rectangle($corner, $width, $height);
        $this->reorderPoints($points, 0);
        $this->polygon($points);
        return $this;
    }

    public function roundedRectangle(
        Point $corner,
        float $width,
        float $height,
        float $radius
    ): self {
        $delta = $radius * self::QUADRANT_FACTOR;
        $rect = Points::roundedRectangle($corner, $width, $height, $radius);
        $points = [
            $rect[0],
            $rect[0]->copy()->translateX(+ $delta),
            $rect[1]->copy()->translateY(- $delta),
            $rect[1],
            $rect[2],
            $rect[2]->copy()->translateY(+ $delta),
            $rect[3]->copy()->translateX(+ $delta),
            $rect[3],
            $rect[4],
            $rect[4]->copy()->translateX(- $delta),
            $rect[5]->copy()->translateY(+ $delta),
            $rect[5],
            $rect[6],
            $rect[6]->copy()->translateY(- $delta),
            $rect[7]->copy()->translateX(- $delta),
            $rect[7]
        ];
        $this->reorderPoints($points, 0);
        $this->m($points[0]);
        $this->c($points[1], $points[2], $points[3]);
        $this->l($points[4]);
        $this->c($points[5], $points[6], $points[7]);
        $this->l($points[8]);
        $this->c($points[9], $points[10], $points[11]);
        $this->l($points[12]);
        $this->c($points[13], $points[14], $points[15]);
        $this->z();
        return $this;
    }

    public function circle(Point $center, float $radius): self
    {
        return $this->ellipse($center, $radius, $radius);
    }

    public function ellipse(Point $center, float $rx, float $ry): self
    {
        $dx = $rx * self::QUADRANT_FACTOR;
        $dy = $ry * self::QUADRANT_FACTOR;
        $cross = Points::cross($center, $rx, $ry);
        $points = [
            $cross[0]->copy(),
            $center->copy()->translate($dx, - $ry),
            $center->copy()->translate($rx, - $dy),
            $cross[1],
            $center->copy()->translate($rx, $dy),
            $center->copy()->translate($dx, $ry),
            $cross[2],
            $center->copy()->translate(- $dx, $ry),
            $center->copy()->translate(- $rx, $dy),
            $cross[3],
            $center->copy()->translate(- $rx, - $dy),
            $center->copy()->translate(- $dx, - $ry),
            $cross[0]
        ];
        $this->reorderPoints($points, 0);
        $this->m($points[0]);
        $this->c($points[1], $points[2], $points[3]);
        $this->c($points[4], $points[5], $points[6]);
        $this->c($points[7], $points[8], $points[9]);
        $this->c($points[10], $points[11], $points[12]);
        return $this;
    }

    public function rotate(Point $center, Angle $angle): self
    {
        foreach ($this->commands as $command) {
            Points::rotate($center, $angle, $command->getPoints());
        }
        return $this;
    }

    public function scale(Point $center, float $factor): self
    {
        foreach ($this->commands as $command) {
            Points::scale($center, $factor, $command->getPoints());
        }
        return $this;
    }

    public function scaleX(Point $center, float $factor): self
    {
        foreach ($this->commands as $command) {
            Points::scaleX($center, $factor, $command->getPoints());
        }
        return $this;
    }

    public function scaleY(Point $center, float $factor): self
    {
        foreach ($this->commands as $command) {
            Points::scaleY($center, $factor, $command->getPoints());
        }
        return $this;
    }

    public function skewX(Point $center, Angle $angle): self
    {
        foreach ($this->commands as $command) {
            Points::skewX($center, $angle, $command->getPoints());
        }
        return $this;
    }

    public function skewY(Point $center, Angle $angle): self
    {
        foreach ($this->commands as $command) {
            Points::skewY($center, $angle, $command->getPoints());
        }
        return $this;
    }

    public function translate(float $deltaX, float $deltaY): self
    {
        foreach ($this->commands as $command) {
            Points::translate($deltaX, $deltaY, $command->getPoints());
        }
        return $this;
    }

    public function translateX(float $deltaX): self
    {
        return $this->translate($deltaX, 0);
    }

    public function translateY(float $deltaY): self
    {
        return $this->translate(0, $deltaY);
    }
}
<?php

namespace App\Services\Exceptions;

use Exception;

class ObstacleEncounteredException extends Exception
{
    public function __construct(
        private int $x,
        private int $y
    ) {
        parent::__construct("Obstacle encountered at position [$x, $y]");
    }

    public function getPosition(): array
    {
        return [$this->x, $this->y];
    }
}

<?php

namespace App\Services;

class RoverService
{
    private array $obstacles;
    private int $gridSize;

    public function __construct(int $gridSize = 50)
    {
        $this->gridSize = $gridSize;
        $this->obstacles = $this->loadObstacles();
    }

    public function moveRover(int $x, int $y, string $direction, string $commands): array
    {
        $currentDirection = $direction;
        $commands = str_split($commands);
        $path = [[$x, $y]];

        if ($this->hasObstacle($x, $y)) {
            return $this->createResult('stopped', 'Initial position is an obstacle.', [$x, $y], $path, true);
        }
        if ($this->isOutOfBounds($x, $y)) {
            return $this->createResult('stopped', 'Initial position is out of bounds.', [$x, $y], $path, false);
        }

        foreach ($commands as $command) {
            $nextPosition = $this->calculateNextPosition($x, $y, $currentDirection, $command);
            $nextX = $nextPosition[0];
            $nextY = $nextPosition[1];
            $currentDirection = $nextPosition[2];

            if ($this->hasObstacle($nextX, $nextY)) {
                return $this->createResult('stopped', 'Encountered an obstacle.', [$x, $y], $path, true);
            }

            if ($this->isOutOfBounds($nextX, $nextY)) {
                return $this->createResult('stopped', 'Moved out of bounds.', [$x, $y], $path, false);
            }

            $x = $nextX;
            $y = $nextY;
            $path[] = [$x, $y];
        }

        return $this->createResult('success', 'Success.', [$x, $y], $path, false);
    }

    private function createResult(
        string $status,
        string $statusText,
        array $position,
        array $path,
        bool $obstacleEncountered
    ): array {
        return [
            'status' => $status,
            'statusText' => $statusText,
            'position' => $position,
            'path' => $path,
            'obstacles' => $this->obstacles,
            'obstacleEncountered' => $obstacleEncountered,
        ];
    }

    private function calculateNextPosition(int $x, int $y, string $direction, string $command): array
    {
        $newX = $x;
        $newY = $y;
        $newDirection = $direction;

        switch ($direction) {
            case 'N':
                if ($command === 'L') {
                    $newX--;
                    $newDirection = 'W';
                } elseif ($command === 'R') {
                    $newX++;
                    $newDirection = 'E';
                } elseif ($command === 'F') {
                    $newY--;
                }
                break;
            case 'S':
                if ($command === 'L') {
                    $newX++;
                    $newDirection = 'E';
                } elseif ($command === 'R') {
                    $newX--;
                    $newDirection = 'W';
                } elseif ($command === 'F') {
                    $newY++;
                }
                break;
            case 'E':
                if ($command === 'L') {
                    $newY--;
                    $newDirection = 'N';
                } elseif ($command === 'R') {
                    $newY++;
                    $newDirection = 'S';
                } elseif ($command === 'F') {
                    $newX++;
                }
                break;
            case 'W':
                if ($command === 'L') {
                    $newY++;
                    $newDirection = 'S';
                } elseif ($command === 'R') {
                    $newY--;
                    $newDirection = 'N';
                } elseif ($command === 'F') {
                    $newX--;
                }
                break;
        }

        return [$newX, $newY, $newDirection];
    }

    private function hasObstacle(int $x, int $y): bool
    {
        return in_array([$x, $y], $this->obstacles, true);
    }

    private function isOutOfBounds(int $x, int $y): bool
    {
        return $x < 1 || $x > $this->gridSize || $y < 1 || $y > $this->gridSize;
    }

    public function getGridSize(): int
    {
        return $this->gridSize;
    }

    public function loadObstacles(): array
    {
        return [
            [2, 10],
            [5, 15],
            [8, 20],
            [12, 25],
            [14, 30],
            [17, 35],
            [20, 40],
            [14, 45],
            [25, 50],
            [13, 32],
            [29, 37],
            [31, 42],
            [34, 48],
            [28, 10],
            [30, 20],
            [29, 30],
            [15, 40],
            [38, 50],
            [40, 5],
            [43, 15],
            [45, 25],
            [48, 35],
            [50, 45]
        ];
    }
}

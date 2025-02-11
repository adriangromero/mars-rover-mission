<?php

namespace Tests\Unit;

use App\Services\RoverService;
use Tests\TestCase;

class RoverServiceTest extends TestCase
{
    protected $roverService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->roverService = new RoverService();
    }

    public function testInitialPositionIsObstacle()
    {
        $result = $this->roverService->moveRover(2, 10, 'N', 'F');

        $this->assertEquals('stopped', $result['status']);
        $this->assertEquals('Initial position is an obstacle.', $result['statusText']);
        $this->assertEquals([2, 10], $result['position']);
        $this->assertTrue($result['obstacleEncountered']);
    }

    public function testInitialPositionOutOfBounds()
    {
        $result = $this->roverService->moveRover(0, 51, 'N', 'F');

        $this->assertEquals('stopped', $result['status']);
        $this->assertEquals('Initial position is out of bounds.', $result['statusText']);
        $this->assertEquals([0, 51], $result['position']);
        $this->assertFalse($result['obstacleEncountered']);
    }

    public function testMoveAndOutOfBounds()
    {
        $result = $this->roverService->moveRover(48, 48, 'E', 'FFFF');

        $this->assertEquals('stopped', $result['status']);
        $this->assertEquals('Moved out of bounds.', $result['statusText']);
        $this->assertEquals([50, 48], $result['position']);
        $this->assertFalse($result['obstacleEncountered']);
    }

}

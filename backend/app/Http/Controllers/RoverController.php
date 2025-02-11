<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RoverService;

class RoverController extends Controller
{
    private RoverService $roverService;

    public function __construct(RoverService $roverService)
    {
        $this->roverService = $roverService;
    }

    public function move(Request $request)
    {
        $validated = $request->validate([
            'x' => 'required|integer|min:1|max:50',
            'y' => 'required|integer|min:1|max:50',
            'direction' => 'required|in:N,S,E,W',
            'commands' => 'required|string|regex:/^[FRL]+$/i'
        ]);

        $result = $this->roverService->moveRover(
            $validated['x'],
            $validated['y'],
            strtoupper($validated['direction']),
            strtoupper($validated['commands'])
        );

        return response()->json([
            'rover' => $result,
            'status' => $result['status']
        ]);
    }

    public function getObstacles()
    {
        return response()->json([
            'obstacles' => $this->roverService->loadObstacles(),
            'gridSize' => $this->roverService->getGridSize(),
        ]);
    }
}

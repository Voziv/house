<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Temperature;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;

class TemperatureController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * @param Request $request
     * @param Room $room
     * @return JsonResource
     * @throws ValidationException
     * @throws AuthorizationException
     */
    public function addReading(Request $request, Room $room): JsonResource
    {
        $this->authorize('createSensorReading', $room);

        $this->validate(
            $request,
            [
                'temperature' => 'required|numeric|between:-50,50',
                'humidity' => 'required|numeric|between:0,100',
            ]
        );

        $newTemp = new Temperature(
            [
                'temperature' => $request->input('temperature'),
                'humidity' => $request->input('humidity'),
            ]
        );
        $room->temperatures()->save($newTemp);

        return JsonResource::make($newTemp);
    }
}

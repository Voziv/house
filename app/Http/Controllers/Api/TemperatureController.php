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

        $temperature = $request->input('temperature');
        $humidity = $request->input('humidity');

        if (!$temperature && !$humidity) {
            throw ValidationException::withMessages(
                [
                    'temperature' => 'You must at least provide one of the following: [temperature, humidity]',
                    'humidity' => 'You must at least provide one of the following: [temperature, humidity]',
                ]
            );
        }

        $newTemp = new Temperature(
            [
                'temperature' => $temperature,
                'humidity' => $humidity,
            ]
        );
        $room->temperatures()->save($newTemp);

        return JsonResource::make($newTemp);
    }
}

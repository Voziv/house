<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConditionReading;
use App\Models\Room;
use App\Models\Sensor;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class ConditionReadingsController extends Controller
{
    /**
     * @param Request $request
     * @param Room $room
     * @return Response
     * @throws AuthorizationException
     */
    public function getReadingsForRoom(Request $request, Room $room): Response
    {
        $this->authorize('viewAny', Room::class);

        $bindings = [
            'room_id' => $room->id,
            'bucket' => $request->input('bucket', '30 minutes'),
            'interval' => $request->input('interval', '24 hours'),
        ];

        $readings = \DB::select(
            "
                    SELECT
                           sensor_id,
                           room_id,
                           time_bucket(:bucket, created_at) as created_at_bucket,
                           ROUND(AVG(temperature), 1) AS temperature_avg,
                           ROUND(AVG(humidity), 1)    AS humidity_avg,
                           MAX(temperature) AS temperature_max,
                           MAX(humidity)    AS humidity_max,
                           MIN(temperature) AS temperature_min,
                           MIN(humidity)    AS humidity_min
                    FROM condition_readings
                    WHERE created_at > NOW() - :interval::interval AND room_id = :room_id
                    GROUP BY sensor_id, room_id, created_at_bucket
                    ORDER BY created_at_bucket DESC;
                "
            ,
            $bindings
        );

        return response()->json($readings);
    }

    /**
     * @param Request $request
     * @param Sensor $sensor
     * @return Response
     * @throws AuthorizationException
     */
    public function getReadingsForSensor(Request $request, Sensor $sensor): Response
    {
        $this->authorize('viewAny', Sensor::class);

        $bindings = [
            'sensor_id' => $sensor->id,
            'bucket' => $request->input('bucket', '30 minutes'),
            'interval' => $request->input('interval', '24 hours'),
        ];

        $readings = \DB::select(
            "
                    SELECT
                           sensor_id,
                           room_id,
                           time_bucket(:bucket, created_at) as created_at_bucket,
                           ROUND(AVG(temperature), 1) AS temperature_avg,
                           ROUND(AVG(humidity), 1)    AS humidity_avg,
                           MAX(temperature) AS temperature_max,
                           MAX(humidity)    AS humidity_max,
                           MIN(temperature) AS temperature_min,
                           MIN(humidity)    AS humidity_min
                    FROM condition_readings
                    WHERE created_at > NOW() - :interval::interval AND sensor_id = :sensor_id
                    GROUP BY sensor_id, room_id, created_at_bucket
                    ORDER BY created_at_bucket DESC;
                "
            ,
            $bindings
        );

        return response()->json($readings);
    }

    /**
     * @param Request $request
     * @param Sensor $sensor
     * @return JsonResource
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function logReading(Request $request, Sensor $sensor): JsonResource
    {
        $this->authorize('createSensorReading', $sensor);

        $validated = $this->validate(
            $request,
            [
                'temperature' => 'required|numeric|between:-50,50',
                'humidity' => 'numeric|between:0,100',
            ]
        );

        $reading = new ConditionReading($validated);

        $reading->sensor_id = $sensor->id;

        if ($sensor->room()->exists()) {
            $reading->room_id = $sensor->room->id;
        }

        $save_success = $reading->save();

        if ($save_success) {
            $sensor->latest_condition_reading()->associate($reading);
            $sensor->save();
            if ($sensor->room()->exists()) {
                $sensor->room->latest_condition_reading()->associate($reading);
                $sensor->room->save();
            }
        }


        return JsonResource::make($reading);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ConditionReading;
use App\Models\Room;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\HttpFoundation\Response;

class ConditionReadingsController extends Controller
{
    /**
     * @param Request $request
     * @return Responsable
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
                           time_bucket(:bucket, created_at) as created_at,
                           AVG(temperature) AS temperature_avg,
                           AVG(humidity)    AS humidity_avg,
                           MAX(temperature) AS temperature_max,
                           MAX(humidity)    AS humidity_max,
                           MIN(temperature) AS temperature_min,
                           MIN(humidity)    AS humidity_min
                    FROM condition_readings
                    WHERE created_at > NOW() - :interval::interval AND room_id = :room_id
                    GROUP BY sensor_id, room_id, created_at
                    ORDER BY created_at DESC;
                "
            ,
            $bindings
        );

        return response()->json($readings);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class RoomsController extends Controller
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
     * @return JsonResource
     * @throws AuthorizationException
     */
    public function listRooms(Request $request): JsonResource
    {
        $this->authorize('viewAny', Room::class);

        $rooms = Room::query()
            ->where('user_id', $request->user()->id)
            ->with('temperatures', 'latest_condition_reading')
            ->get();

        return JsonResource::make($rooms);
    }

    /**
     * @param Room $room
     * @return JsonResource
     * @throws AuthorizationException
     */
    public function getRoom(Room $room): JsonResource
    {
        $this->authorize('view', $room);

        $room->load('latest_condition_reading');

        return JsonResource::make($room);
    }

    /**
     * @param Request $request
     * @return JsonResource
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function createRoom(Request $request): JsonResource
    {
        $this->authorize('create', Room::class);

        $name = $request->input('name');
        $slug = Str::slug($name);

        /** @var Room $room */
        $room = Room::query()->where('slug', $slug)->first();

        if ($room) {
            throw ValidationException::withMessages(['name' => 'There is another room with this name']);
        }

        $room = new Room(['name' => $name, 'slug' => $slug]);
        $request->user()->rooms()->save($room);

        return JsonResource::make($room);
    }

    /**
     * @param Request $request
     * @param Room $room
     * @return JsonResource
     * @throws AuthorizationException
     * @throws ValidationException
     */
    public function saveRoom(Request $request, Room $room): JsonResource
    {
        $this->authorize('update', $room);

        $name = $request->input('name');
        $newSlug = Str::slug($name);


        if (Room::query()->where('slug', $newSlug)->exists()) {
            throw ValidationException::withMessages(['name' => 'There is another room with this name']);
        }

        $room->name = $name;
        $room->slug = $newSlug;

        $room->save();

        return JsonResource::make($room);
    }
}

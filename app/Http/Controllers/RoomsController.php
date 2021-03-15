<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

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

    public function index(Request $request)
    {
        $this->authorize('viewAny', Room::class);

        /** @var User $user */
        $user = $request->user();

        $rooms = Room::query()
            ->where('user_id', $user->id)
            ->with('latest_condition_reading')
            ->orderBy('name')
            ->get();

        return Inertia::render(
            'Rooms/List',
            [
                'rooms' => $rooms,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param Room $room
     * @return Response|Responsable
     */
    public function show(Request $request, Room $room)
    {
        $this->authorize('view', $room);

        $room->load(['latest_condition_reading']);

        return Inertia::render(
            'Rooms/Show',
            [
                'room' => $room,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response|Responsable
     */
    public function create(Request $request)
    {
        $this->authorize('create', Room::class);

        return Inertia::render('Rooms/Create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $this->authorize('create', Room::class);

        $validated = $this->validate(
            $request,
            [
                'name' => ['required'],
                'slug' => [
                    'required',
                    'alpha_dash',
                    Rule::unique(Room::class, 'slug'),
                ],
            ]
        );


        $room = new Room($validated);
        $room->user_id = $request->user()->id;
        $room->save();

        return Redirect::route('rooms.index')
            ->with('message', "{$room->name} created successfully.");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param Room $room
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, Room $room): Response
    {
        $this->authorize('update', $room);

        $validated = $this->validate(
            $request,
            [
                'name' => ['required'],
            ]
        );

        $room->update($validated);

        return Redirect::route('rooms.index')
            ->with('message', "Room updated successfully.");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param Room $room
     * @return Response
     * @throws Exception
     */
    public function destroy(Request $request, Room $room): Response
    {
        $room->delete();

        return Redirect::route('rooms.index')
            ->with('message', "Room deleted successfully.");
    }
}

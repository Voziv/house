<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Sensor;
use App\Models\User;
use Exception;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class SensorsController extends Controller
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
        $this->authorize('viewAny', Sensor::class);

        /** @var User $user */
        $user = $request->user();

        $sensors = Sensor::query()
            ->where('user_id', $user->id)
            ->get();

        return Inertia::render(
            'Sensors/List',
            [
                'sensors' => $sensors,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param Sensor $sensor
     * @return Response|Responsable
     */
    public function show(Request $request, Sensor $sensor)
    {
        $this->authorize('view', $sensor);

        $sensor->load(
            [
                'room',
                'latest_reading' => function ($query) {
                    return $query->latest()->first();
                },
            ]
        );
        return Inertia::render(
            'Sensors/Show',
            [
                'sensor' => $sensor,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param Sensor $sensor
     * @return Response|Responsable
     */
    public function edit(Request $request, Sensor $sensor)
    {
        $this->authorize('update', $sensor);

        $sensor->load(
            [
                'room',
            ]
        );

        $user = $request->user();

        $rooms = Room::query()->where('user_id', $request->user()->id)->get();

        return Inertia::render(
            'Sensors/Edit',
            [
                'sensor' => $sensor,
                'rooms' => $rooms,
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
        $this->authorize('create', Sensor::class);

        return Inertia::render('Sensors/Create');
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
        $this->authorize('create', Sensor::class);

        $validated = $this->validate(
            $request,
            [
                'name' => ['required'],
                'room_id' => ['numeric'],
                'slug' => [
                    'required',
                    'alpha_dash',
                    Rule::unique(Sensor::class, 'slug'),
                ],
            ]
        );

        $sensor = new Sensor($validated);
        $sensor->user_id = $request->user()->id;

        if ($validated['room_id'] == 0) {
            $validated['room_id'] = null;
        }

        if ($validated['room_id']) {
            $room = Room::find($validated['room_id']);
            $this->authorize('create', $room);

            $sensor->room_id = $room->id;
        }


        $sensor->save();

        return Redirect::route('sensors.index')
            ->with('message', "{$sensor->name} created successfully.");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param Sensor $sensor
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request, Sensor $sensor): Response
    {
        $this->authorize('update', $sensor);

        $validated = $this->validate(
            $request,
            [
                'name' => ['required'],
                'slug' => ['alpha_dash'],
                'room_id' => ['numeric'],
            ]
        );

        if ($validated['room_id'] == 0) {
            $validated['room_id'] = null;
        }

        if ($validated['room_id']) {
            $room = Room::find($validated['room_id']);
            $this->authorize('create', $room);
        }

        $sensor->update($validated);

        return Redirect::route('sensors.show', ['sensor' => $sensor->slug])
            ->with('message', "Sensor updated successfully.");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @param Sensor $sensor
     * @return Response
     * @throws Exception
     */
    public function destroy(Request $request, Sensor $sensor): Response
    {
        $this->authorize('destroy', $sensor);

        $sensor->delete();

        return Redirect::route('sensors.index')
            ->with('message', "Sensor deleted successfully.");
    }
}

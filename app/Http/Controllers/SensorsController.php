<?php

namespace App\Http\Controllers;

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
        $sensor->load('room');
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
     * @return Response|Responsable
     */
    public function create(Request $request)
    {
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
        $validated = $this->validate(
            $request,
            [
                'name' => ['required'],
                'slug' => [
                    'required',
                    'alpha_dash',
                    Rule::unique(Sensor::class, 'slug'),
                ],
            ]
        );


        $sensor = new Sensor($validated);
        $sensor->user_id = $request->user()->id;
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
        $validated = $this->validate(
            $request,
            [
                'name' => ['required'],
            ]
        );

        $sensor->update($validated);

        return Redirect::route('sensors.index')
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
        $sensor->delete();

        return Redirect::route('sensors.index')
            ->with('message', "Sensor deleted successfully.");
    }
}

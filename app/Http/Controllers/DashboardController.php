<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DashboardController extends Controller
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
        $rooms = Room::query()
            ->where('user_id', $request->user()->id)
            ->has('sensor')
            ->with('latest_condition_reading')
            ->get();

        return Inertia::render(
            'Dashboard',
            [
                'rooms' => $rooms,
            ]
        );
    }
}

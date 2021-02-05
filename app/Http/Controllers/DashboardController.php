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
            ->get();

        $rooms->load(
            [
                'condition_readings' => function ($query) {
                    return $query->limit(60 * 24);
                },
                'current_condition_reading' => function ($query) {
                    return $query->limit(1)->latest();
                },
            ]
        );

        return Inertia::render(
            'Dashboard',
            [
                'rooms' => $rooms,
            ]
        );
    }
}

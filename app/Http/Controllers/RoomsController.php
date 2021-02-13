<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

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
        /** @var User $user */
        $user = $request->user();

        $rooms = Room::query()
            ->where('user_id', $user->id)
            ->get();

        return Inertia::render(
            'Rooms/List',
            [
                'rooms' => $rooms,
            ]
        );
    }
}

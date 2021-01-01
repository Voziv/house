<?php

namespace App\Policies;

use App\Enum\Permission;
use App\Models\Room;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RoomPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->tokenCan(Permission::READ_ANY);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Room $room
     * @return mixed
     */
    public function view(User $user, Room $room)
    {
        return $user->id === $room->user_id && $user->tokenCan(Permission::READ_ANY);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->tokenCan(Permission::CREATE_ANY);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Room $room
     * @return mixed
     */
    public function update(User $user, Room $room)
    {
        return $user->id === $room->user_id && $user->tokenCan(Permission::UPDATE_ANY);
    }

    /**
     * Determine whether the user can record temperature sensor readings for a room.
     *
     * @param User $user
     * @param Room $room
     * @return mixed
     */
    public function createSensorReading(User $user, Room $room)
    {
        return $user->id === $room->user_id &&
            (
                $user->tokenCan(Permission::CREATE_ANY) ||
                $user->tokenCan(Permission::SENSOR_READING_WRITE)
            );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Room $room
     * @return mixed
     */
    public function delete(User $user, Room $room)
    {
        return $user->id === $room->user_id && $user->tokenCan(Permission::DELETE_ANY);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Room $room
     * @return mixed
     */
    public function restore(User $user, Room $room)
    {
        return $this->delete($user, $room);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Room $room
     * @return mixed
     */
    public function forceDelete(User $user, Room $room)
    {
        return $this->delete($user, $room);
    }
}

<?php

namespace App\Policies;

use App\Enum\Permission;
use App\Models\Sensor;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SensorPolicy
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
     * @param Sensor $sensor
     * @return mixed
     */
    public function view(User $user, Sensor $sensor)
    {
        return $user->id === $sensor->user_id && $user->tokenCan(Permission::READ_ANY);
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
     * @param Sensor $sensor
     * @return mixed
     */
    public function update(User $user, Sensor $sensor)
    {
        return $user->id === $sensor->user_id && $user->tokenCan(Permission::UPDATE_ANY);
    }

    /**
     * Determine whether the user can record temperature sensor readings for a sensor.
     *
     * @param User $user
     * @param Sensor $sensor
     * @return mixed
     */
    public function createSensorReading(User $user, Sensor $sensor)
    {
        return $user->id === $sensor->user_id &&
            (
                $user->tokenCan(Permission::CREATE_ANY) ||
                $user->tokenCan(Permission::SENSOR_READING_WRITE)
            );
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Sensor $sensor
     * @return mixed
     */
    public function destroy(User $user, Sensor $sensor)
    {
        return $user->id === $sensor->user_id && $user->tokenCan(Permission::DELETE_ANY);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param User $user
     * @param Sensor $sensor
     * @return mixed
     */
    public function restore(User $user, Sensor $sensor)
    {
        return $this->delete($user, $sensor);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param User $user
     * @param Sensor $sensor
     * @return mixed
     */
    public function forceDestroy(User $user, Sensor $sensor)
    {
        return $this->delete($user, $sensor);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Sensor
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $user_id
 * @property int|null $room_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $latest_condition_reading_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConditionReading[] $condition_readings
 * @property-read int|null $condition_readings_count
 * @property-read \App\Models\ConditionReading|null $latest_condition_reading
 * @property-read \App\Models\Room|null $room
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor whereLatestConditionReadingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor whereUserId($value)
 * @mixin \Eloquent
 */
class Sensor extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'room_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function condition_readings()
    {
        return $this->hasMany(ConditionReading::class);
    }

    public function latest_condition_reading()
    {
        return $this->belongsTo(ConditionReading::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

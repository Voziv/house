<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ConditionReading
 *
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $temperature
 * @property string|null $humidity
 * @property int $sensor_id
 * @property int $room_id
 * @property-read \App\Models\Room $room
 * @property-read \App\Models\Sensor $sensor
 * @method static \Illuminate\Database\Eloquent\Builder|ConditionReading newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConditionReading newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ConditionReading query()
 * @method static \Illuminate\Database\Eloquent\Builder|ConditionReading whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConditionReading whereHumidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConditionReading whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConditionReading whereSensorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConditionReading whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ConditionReading whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ConditionReading extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'temperature',
        'humidity',
    ];

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

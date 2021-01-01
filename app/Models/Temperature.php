<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Temperature
 *
 * @property int $id
 * @property string|null $temperature
 * @property string|null $humidity
 * @property int $room_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Room $room
 * @method static \Illuminate\Database\Eloquent\Builder|Temperature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Temperature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Temperature query()
 * @method static \Illuminate\Database\Eloquent\Builder|Temperature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Temperature whereHumidity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Temperature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Temperature whereRoomId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Temperature whereTemperature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Temperature whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Temperature extends Model
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

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}

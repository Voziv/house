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
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ConditionReading|null $currentCondition
 * @property-read \App\Models\Room $room
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor query()
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Sensor whereName($value)
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
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function conditionReadings()
    {
        return $this->hasMany(ConditionReading::class);
    }

    public function currentConditionReading()
    {
        return $this->hasMany(ConditionReading::class)->latest();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Room
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConditionReading[] $conditionReadings
 * @property-read int|null $condition_readings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConditionReading[] $currentConditionReading
 * @property-read int|null $current_condition_reading_count
 * @property-read \App\Models\Sensor|null $sensor
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereUserId($value)
 * @mixin \Eloquent
 */
class Room extends Model
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

    public function sensor()
    {
        return $this->hasOne(Sensor::class);
    }

    public function condition_readings()
    {
        return $this->hasMany(ConditionReading::class);
    }

    public function latest_reading()
    {
        return $this->hasOne(ConditionReading::class)->latest()->limit(1);
    }

    public function current_condition_reading()
    {
        return $this->hasMany(ConditionReading::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

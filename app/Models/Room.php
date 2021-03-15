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
 * @property int|null $latest_condition_reading_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ConditionReading[] $condition_readings
 * @property-read int|null $condition_readings_count
 * @property-read \App\Models\ConditionReading|null $latest_condition_reading
 * @property-read \App\Models\Sensor|null $sensor
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Room newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Room query()
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Room whereLatestConditionReadingId($value)
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

    public function latest_condition_reading()
    {
        return $this->belongsTo(ConditionReading::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

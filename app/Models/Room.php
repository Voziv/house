<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Expression;

/**
 * App\Models\Room
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Temperature|null $latest_reading
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Temperature[] $temperatures
 * @property-read int|null $temperatures_count
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

    public function temperatures()
    {
        $daysOfData = 1;
        $interval = 5;
        return $this->hasMany(Temperature::class)
            ->where('humidity', '>=', 0)
            ->where('humidity', '<=', 100)
            ->where('temperature', '>=', -40)
            ->where('temperature', '<=', 25)
            ->whereRaw("MINUTE(created_at) % $interval = 0")
            ->limit(60 / $interval * 24 * $daysOfData)
            ->orderBy('created_at', 'DESC');
    }

    public function temperatures_week()
    {
        $daysOfData = 7;
        $interval = 15;
        return $this->hasMany(Temperature::class)
            ->where('humidity', '>=', 0)
            ->where('humidity', '<=', 100)
            ->where('temperature', '>=', -40)
            ->where('temperature', '<=', 25)
            ->whereRaw("MINUTE(created_at) % $interval = 0")
            ->limit(60 / $interval * 24 * $daysOfData)
            ->orderBy('created_at', 'DESC');
    }

    public function latest_reading()
    {
        return $this->hasOne(Temperature::class)->latest();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}

<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Models\Event
 *
 * @property int $id
 * @property string $name
 * @property string $date
 * @property int $active
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|Event newModelQuery()
 * @method static Builder|Event newQuery()
 * @method static Builder|Event query()
 * @method static Builder|Event whereActive($value)
 * @method static Builder|Event whereCreatedAt($value)
 * @method static Builder|Event whereDate($value)
 * @method static Builder|Event whereId($value)
 * @method static Builder|Event whereName($value)
 * @method static Builder|Event whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date'
    ];

    protected $casts = [
        'active' => 'integer',
    ];

    public static function closeOldEvents()
    {
        return Event::where('active', 1)
            ->update(['active' => 0]);
    }
}

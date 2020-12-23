<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'date'
    ];

    protected $casts = [
        'active' => 'integer',
        'date' => 'date'
    ];

    public static function closeOldEvents()
    {
        return Event::where('active', 1)
            ->update(['active' => 0]);
    }
}

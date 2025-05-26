<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = ['title', 'description', 'datetime', 'location', 'category', 'capacity'];

    protected $casts = [
        'datetime' => 'datetime',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}


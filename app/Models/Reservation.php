<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $fillable = [
        'user_id',
        'schedule_id',
        'estado',
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function horario()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}

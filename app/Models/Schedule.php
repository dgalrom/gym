<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'class_id',
        'fecha',
        'hora_inicio',
        'hora_fin',
    ];

    protected $casts = [
        'fecha' => 'date',
    ];

    public function clase()
    {
        return $this->belongsTo(TrainingClass::class, 'class_id');
    }

    public function reservas()
    {
        return $this->hasMany(Reservation::class, 'schedule_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrainingClass extends Model
{
    protected $table = 'training_classes';

    protected $fillable = [
        'nombre',
        'descripcion',
        'duracion',
        'capacidad',
        'imagen',
        'entrenador_id',
    ];

    public function entrenador()
    {
        return $this->belongsTo(User::class, 'entrenador_id');
    }

    public function horarios()
    {
        return $this->hasMany(Schedule::class, 'class_id');
    }
}

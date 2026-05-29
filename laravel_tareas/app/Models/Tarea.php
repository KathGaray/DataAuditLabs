<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Tarea extends Model
{
    protected $fillable = ['user_id', 'titulo', 'descripcion', 'estado'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeMias($query)
    {
        return $query->where('user_id', Auth::id());
    }
}

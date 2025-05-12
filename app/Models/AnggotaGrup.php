<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnggotaGrup extends Model
{
    protected $fillable = ['grup_id', 'user_id'];

    public function grup()
    {
        return $this->belongsTo(GrupRelawan::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

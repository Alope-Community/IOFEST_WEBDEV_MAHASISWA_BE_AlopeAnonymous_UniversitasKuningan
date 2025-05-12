<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestimoniRating extends Model
{
    protected $fillable = ['user_id', 'program_id', 'testimoni', 'rating', 'tanggal'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(ProgramRelawan::class);
    }
}

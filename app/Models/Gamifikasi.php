<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gamifikasi extends Model
{
    protected $fillable = ['user_id', 'aktivitas', 'poin_diberikan', 'tanggal'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

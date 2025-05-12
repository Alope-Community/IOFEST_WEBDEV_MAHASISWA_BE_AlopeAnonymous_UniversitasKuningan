<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $fillable = ['user_id', 'pesan', 'status', 'tanggal'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

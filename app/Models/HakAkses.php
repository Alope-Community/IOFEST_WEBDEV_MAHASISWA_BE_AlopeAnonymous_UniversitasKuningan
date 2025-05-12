<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HakAkses extends Model
{
    protected $fillable = ['role', 'modul', 'hak_akses', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

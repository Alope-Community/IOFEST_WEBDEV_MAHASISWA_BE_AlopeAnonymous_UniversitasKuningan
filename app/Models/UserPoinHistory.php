<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPoinHistory extends Model
{
    protected $fillable = [
        'user_id',
        'aktivitas',
        'point',
        'keterangan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

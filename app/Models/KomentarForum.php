<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KomentarForum extends Model
{
    protected $fillable = ['forum_id', 'user_id', 'komentar', 'tanggal_komentar'];

    public function forum()
    {
        return $this->belongsTo(ForumDiskusi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

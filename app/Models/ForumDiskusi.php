<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumDiskusi extends Model
{
    protected $fillable = ['judul', 'konten', 'user_id', 'tanggal_dibuat'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(ProgramRelawan::class);
    }

    public function komentars()
    {
        return $this->hasMany(KomentarForum::class, 'forum_id');
    }
}

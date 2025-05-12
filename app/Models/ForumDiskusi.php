<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumDiskusi extends Model
{
    protected $fillable = ['program_id', 'judul', 'konten', 'tanggal_dibuat'];

    public function program()
    {
        return $this->belongsTo(ProgramRelawan::class);
    }

    public function komentar()
    {
        return $this->hasMany(KomentarForum::class, 'forum_id');
    }
}

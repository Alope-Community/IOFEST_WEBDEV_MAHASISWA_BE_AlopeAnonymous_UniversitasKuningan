<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galeri extends Model
{
    protected $fillable = ['program_id', 'tipe_media', 'file_path', 'tanggal_upload'];

    public function program()
    {
        return $this->belongsTo(ProgramRelawan::class);
    }
}

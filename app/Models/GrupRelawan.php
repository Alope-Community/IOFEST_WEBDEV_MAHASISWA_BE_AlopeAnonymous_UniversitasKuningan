<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrupRelawan extends Model
{
    protected $fillable = ['nama_grup', 'deskripsi', 'program_id'];

    public function program()
    {
        return $this->belongsTo(ProgramRelawan::class);
    }

    public function anggota()
    {
        return $this->hasMany(AnggotaGrup::class, 'grup_id');
    }
}

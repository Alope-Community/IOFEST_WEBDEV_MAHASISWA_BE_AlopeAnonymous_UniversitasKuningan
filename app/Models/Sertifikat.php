<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sertifikat extends Model
{
    protected $fillable = ['user_id', 'program_id', 'tanggal_diterbitkan', 'sertifikat_url'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function program()
    {
        return $this->belongsTo(ProgramRelawan::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonasiPeserta extends Model
{
    protected $fillable = ['user_id', 'program_donasi_id', 'nominal', 'ucapan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programDonasi()
    {
        return $this->belongsTo(ProgramDonasi::class);
    }
}

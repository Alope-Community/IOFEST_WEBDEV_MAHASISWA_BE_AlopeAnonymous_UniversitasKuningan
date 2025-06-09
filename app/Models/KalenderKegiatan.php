<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KalenderKegiatan extends Model
{
    protected $fillable = ['program_id', 'nama_kegiatan', 'tanggal', 'lokasi'];

    public function program()
    {
        return $this->belongsTo(ProgramRelawan::class);
    }
}

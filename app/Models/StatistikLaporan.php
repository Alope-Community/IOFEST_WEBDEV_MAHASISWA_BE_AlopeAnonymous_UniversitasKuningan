<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatistikLaporan extends Model
{
    protected $fillable = ['user_id', 'tipe_laporan', 'program_id', 'data_laporan', 'tanggal_dibuat'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function program()
    {
        return $this->belongsTo(ProgramRelawan::class);
    }
}

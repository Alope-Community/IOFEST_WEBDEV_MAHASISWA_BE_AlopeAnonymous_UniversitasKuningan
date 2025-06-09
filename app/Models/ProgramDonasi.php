<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramDonasi extends Model
{
    protected $fillable = ['nama_program', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'user_id', 'gambar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pesertas()
    {
        return $this->hasMany(DonasiPeserta::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramRelawan extends Model
{
    protected $fillable = ['nama_program', 'deskripsi', 'status', 'tanggal_mulai', 'tanggal_selesai', 'user_id', 'gambar'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pesertas()
    {
        return $this->hasMany(RelawanPeserta::class);
    }

    public function sertifikat()
    {
        return $this->hasOne(Sertifikat::class);
    }

    public function testimoniRatings()
    {
        return $this->hasMany(TestimoniRating::class);
    }

    public function forumDiskusi()
    {
        return $this->hasMany(ForumDiskusi::class);
    }

    public function kalenderKegiatan()
    {
        return $this->hasMany(KalenderKegiatan::class);
    }

    public function statistikLaporan()
    {
        return $this->hasMany(StatistikLaporan::class);
    }
}
